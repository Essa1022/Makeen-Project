<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\Comment\CreateCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Article;

class CommentController extends Controller
{
       // Comment index:
       public function index(Article $article)
       {
           $comments = $article->comments()
               ->where('status', true)
               ->paginate(10);
            return CommentResource::collection($comments);
       }

       // All Comments
       public function all(Request $request)
       {
            if($request->user()->can('see.comment'))
            {
                $comments = Comment::orderby('id', 'desc')->paginate(10);
                return $this->responseService->success_response($comments);
            }
            else
            {
                return $this->responseService->unauthorized_response();
            }
       }

       // Counts null status Comments
        public function null_count()
        {
            $comments = Comment::whereNull('status')->count();
            return $this->responseService->success_response($comments);
        }

        // Store a new Comment or Reply
        public function store(CreateCommentRequest $request, Article $article, Comment $comment = null)
        {
            $input = $request->except(['status']);
            $input['article_id'] = $article->id;

            if($comment)
            {
                $input['comment_id'] = $comment->id;
            }
            $comment = Comment::create($input);
            return $this->responseService->success_response($comment);
        }

       // Change status of a Comment
       public function change_status(UpdateCommentRequest $request, string $id, bool $status)
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

        // Destroy Comment
        public function destroy(Request $request)
        {
            if($request->user()->can('delete.comment'))
            {
                $comment_ids = $request->input('comment_ids');
                Comment::destroy($comment_ids);
                return $this->responseService->delete_response();
            }
            else
            {
                return $this->responseService->unauthorized_response();
            }
        }
}
