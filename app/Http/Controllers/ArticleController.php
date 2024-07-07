<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Article index
    public function index(Request $request)
    {
            $articles = new Article();

            if($request->most_view)
            {
                $articles = $articles->select(['id','title'])
                ->orderBy('views', 'desc')->take(10)->get();
            }
            if($request->most_comments)
            {
                $articles = $articles->withCount('comments')
                ->orderBy('comments_count', 'desc')->take(10)->get();
            }
            if($request->chosen)
            {
                $articles = $articles->whereHas('labels', function(Builder $querry)
                {
                    $querry->where('name', 'برگزیده');
                })->take(10)->get();
            }
            if($request->last)
            {
                $articles = $articles->orderBy('id', 'desc')->take(10)->get();
            }

            $articles = $articles->paginate(10);
            return $this->responseService->success_response($articles);
    }

    // Show specific Article
    public function show(Request $request, string $id)
    {
        $article = Article::find($id);
        $article->increment('views');
        return $this->responseService->success_response($article);
    }

    // Store a new Article
    public function store(CreateArticleRequest $request)
    {
        if($request->user()->can('create.article'))
        {
            $article = Article::create($request->merge(['user_id' => $request->user()->id])
            ->toArray());
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
            if ($request->user()->hasRole(['Admin', 'Super_Admin']))
            {
                $article->update($request->toArray());
            }
            else
            {
                $article->update($request->merge(['visibility' => $article->visibility])
                ->toArray());
            }
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
        if($request->user()->can('destroy.article'))
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
