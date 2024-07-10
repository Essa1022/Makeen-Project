<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\Comment\CreateCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Article;

class CommentController extends Controller
{
       // comment index:
       public function index(Request $request, Article $article = null)
       {
            if($article)
            {
                $comment = $article->comments()->where('status', true)->paginate(10);
            }
            else
            {
                if($request->user()->can('see.comment'))
                {
                    $comment = Comment::orderby('id', 'desc')->paginate(10);
                }
                else
                {
                    return $this->responseService->unauthorized_response();
                }
            }
            return $this->responseService->success_response($comment);
       }

        // Store a new Comment or Reply
        public function store(CreateCommentRequest $request, Article $article, Comment $id)
        {
            $input = $request->except(['status']);
            $input['article_id'] = $article;

            if($id)
            {
                $input['comment_id'] = $id;
            }

            $comment = Comment::create($input);
            return $this->responseService->success_response($comment);
        }

       // Update comment:
       public function update(UpdateCommentRequest $request, string $id, $status)
       {
           if($request->user()->can('update.comment'))
           {
               $comment = Comment::find($id)->update(['status' => $status]);
               return $this->responseService->success_response($comment);
           }
           else
           {
               return $this->responseService->unauthorized_response();
           }
       }
}
