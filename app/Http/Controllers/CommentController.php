<?php

namespace App\Http\Controllers;

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
               ->whereNull('comment_id')
               ->with(['replies' => function($query) {
                   $query->where('status', true);
               }])
               ->withCount([
                   'likes as likes_count' => function ($query) {
                       $query->where('type', 'like');
                   },
                   'likes as dislikes_count' => function ($query)
                   {
                       $query->where('type', 'dislike');
                   }])
               ->paginate(10);

           return $this->responseService->success_response($comments);
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
