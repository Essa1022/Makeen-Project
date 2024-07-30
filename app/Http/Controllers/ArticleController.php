<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Requests\Media\UploadMediaRequest;
use App\Http\Resources\Article\ArticleResource as ArticleArticleResource;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ArticleController extends Controller
{
    // Article filter
    public function filter(Request $request, Category $category = null)
    {
            $articles = Article::select(['id', 'title'])->where('status', true);

            if($category)
            {
                $articles = $articles->select(['id', 'title'])->where('category_id', $category->id)->where('status', true);
            }

            if($request->most_view)
            {
                $articles = $articles->orderBy('views', 'desc');
            }
            elseif($request->most_comments)
            {
                $articles = $articles->withCount('comments')
                ->orderBy('comments_count', 'desc');
            }
            elseif($request->label)
            {
                $articles = $articles->whereHas('labels', function(Builder $querry)use($request)
                {
                    $querry->where('name', $request->label);
                });
            }
            elseif($request->last)
            {
                $articles = $articles->orderBy('id', 'desc');
            }
            if($articles->count() == 0)
            {
                return $this->responseService->notFound_response();
            }

            $articles = $articles->paginate(10);
            return $this->responseService->success_response($articles);
    }

    // Article index
    public function index(Request $request, Category $category = null)
    {
        $articles = new Article();
        if($category)
        {
            $articles = $articles->where('category_id', $category->id);
        }
        if($request->label)
        {
            $articles = $articles->whereHas('labels', function(Builder $querry)use($request)
            {
                $querry->where('name', $request->label);
            });
        }
        if($articles->count() == 0)
        {
            return $this->responseService->notFound_response();
        }

        $articles = $articles->orderBy('id', 'desc')->paginate(5);
        return ArticleResource::collection($articles);
    }

    // Article all
    public function all(Request $request)
    {
        if($request->user()->can('see.article'))
        {
        $articles = Article::orderBy('id', 'desc')->paginate(10);
        return response()->json($articles);
        return $this->responseService->success_response($articles);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Show specific Article
    public function show(Request $request, string $slug)
    {
        $article = Article::with(['comments'])->where('slug', $slug)->first();
        if (!$article)
        {
            return $this->responseService->notFound_response();
        }
        $article->increment('views');
        return ArticleResource::make($article);
    }

    // Store a new Article
    public function store(CreateArticleRequest $request)
    {
        if($request->user()->can('create.article'))
        {
            $input = $request->except(['status', 'view', 'slug']);
            $input['user_id'] = $request->user()->id;
            $input['slug'] = Str::slug($input['title']);

            $article = Article::create($input);

            $mediaRequest = UploadMediaRequest::createFromBase($request);
            $mediaRequest->setUserResolver(function () use ($request) {
                return $request->user();
            });
            app(MediaController::class)->upload($mediaRequest, 'main_image', $article->id);
            app(MediaController::class)->upload($mediaRequest, 'second_image', $article->id);
            $article->load('media');
            return $this->responseService->success_response($article);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Update Article
    public function update(UpdateArticleRequest $request, string $id)
    {
        $article = Article::find($id);

        if ($request->user()->can('update.article') || $request->user()->id == $article->user_id)
        {
                $input = $request->except(['view', 'slug']);

                if (!$request->user()->hasRole(['Admin', 'Super_Admin']))
                {
                    unset($input['status']);
                }
                $article->update($input);
                return $this->responseService->success_response($article);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Destroy Article
    public function destroy(Request $request)
    {
        if($request->user()->can('delete.article'))
        {
            $article_ids = $request->input('article_ids');
            Article::destroy($article_ids);
            return $this->responseService->delete_response();
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }
}

