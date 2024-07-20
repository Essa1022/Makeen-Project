<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            $articles = $articles->with('media')->where('category_id', $category->id);
        }
        if($request->label)
        {
            $articles = $articles->with('media')->whereHas('labels', function(Builder $querry)use($request)
            {
                $querry->where('name', $request->label);
            });
        }
        if($articles->count() == 0)
        {
            return $this->responseService->notFound_response();
        }

        $articles = $articles->where('status', true)
            ->orderBy('id', 'desc')
            ->paginate(5);
        return $this->responseService->success_response($articles);
    }

    // Article all
    public function all(Request $request)
    {
        if($request->user()->can('see.article'))
        {
        $articles = Article::orderBy('id', 'desc')->paginate(10);
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
        $article = Article::with(['media', 'comments'])->where('slug', $slug)->first();
        if (!$article)
        {
            return $this->responseService->notFound_response();
        }
        $article->increment('views');
        return $this->responseService->success_response($article);
    }

    // Store a new Article
    public function store(CreateArticleRequest $request)
    {
        if($request->user()->can('create.article'))
        {
            $input = $request->except(['status', 'view', 'slug']);
            $input['user_id'] = $request->user()->id;
            if(empty($input['slug']))
            {
                $input['slug'] = Str::slug($input['title']);
            }

            $article = Article::create($input);
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

