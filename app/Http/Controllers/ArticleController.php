<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Requests\Media\UploadMediaRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Article\ArticleSummaryResource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class ArticleController extends Controller
{
    // Article filter
    public function filter(Request $request, Category $category = null)
    {
            $articles = Article::select(['id', 'title']);

            if($category)
            {
                $articles = $articles->whereHas('categories', function($query)use($category)
                {
                    $query->where('id', $category->id);
                });
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

            $articles = $articles->where('status', true)->paginate(10);
            return $this->responseService->success_response($articles);
    }


    // Article index
    public function index(Request $request, Category $category = null)
    {
        $articles = new Article();

        if ($request->special_words)
        {
            $articles = $articles->where('special_words', $request->special_words);
        }

        else
        {
            if ($category)
            {
                $articles = $articles->whereHas('categories', function($query) use ($category) {
                    $query->where('id', $category->id);
                });
            }

            if ($request->label)
            {
                $articles = $articles->whereHas('labels', function(Builder $query) use ($request) {
                    $query->where('name', $request->label);
                });
            }

            if ($request->video)
            {
                $articles = $articles->whereHas('media', function($query) {
                    $query->where('mime_type', 'video/mp4');
                });
            }
        }

        $jalaliDate = $request->input('date');
        if ($jalaliDate)
        {
            $date = Jalalian::fromFormat('Y-m-d', $jalaliDate)->toCarbon();
            $articles = Article::whereDate('created_at', '=', $date->format('Y-m-d'))->get();
        }

        $articles = $articles->where('status', true)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return ArticleSummaryResource::collection($articles);
    }


    // All Articles for Admin
    public function all(Request $request)
    {
        $articles = new Article();

        if($request->user()->can('see.article') || $request->user()->id == $articles->user_id)
        {
            if ($request->label)
            {
                $articles = $articles->whereHas('labels', function(Builder $query) use ($request) {
                    $query->where('name', $request->label);
                });
            }

            $articles = $articles->with('categories')
                ->orderBy('id', 'desc')
                ->paginate(10);
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
        $article = Article::with(['comments'])->where('slug', $slug)
            ->where('status', true)
            ->first();

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
            $input = $request->except(['views', 'slug', 'status']);
            $input['user_id'] = $request->user()->id;
            $input['slug'] = Str::slug($input['title']);
            $article = Article::create($input);
            $article->categories()->attach($request->category_ids);
            $article->labels()->attach($request->label_ids);


            $mediaRequest = UploadMediaRequest::createFromBase($request);
            $mediaRequest->setUserResolver(function () use ($request) {
                return $request->user();
            });
            app(MediaController::class)->upload($mediaRequest, 'main_image', $article->id);
            app(MediaController::class)->upload($mediaRequest, 'second_image', $article->id);
            return ArticleResource::make($article);
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
            $input = $request->except(['view', 'slug', 'status']);
            $article->update($input);
            $article->categories()->sync($request->category_ids);
            $article->labels()->sync($request->label_ids);
            return $this->responseService->success_response($article);
        }

        else
        {
            return $this->responseService->unauthorized_response();
        }
    }


    // change status
    public function change_status(Request $request, string $id, $status)
    {
        if ($request->user()->hasRole(['Super_Admin', 'Admin']))
        {
            $article = Article::find($id);
            $article->update(['status' => $status]);
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

