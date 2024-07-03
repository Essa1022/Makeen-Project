<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\Comment\CreateCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;

class CommentController extends Controller
{
       //////////////////////////////////////////////////////////////////// comment index:
       public function index(Request $request)
       {
           if($request->user()->can('index.comment'))
           {
               $comment = Comment::all();
               return $this->responseService->success_response($comment);
           }
           else
           {
               return $this->responseService->unauthorized_response();
           }
       }

       ////////////////////////////////////////////////////////////////// Show specific Comment:
       public function show(Request $request, string $id)
       {
           if($request->user()->can('show.comment'))
           {
               $comment = Comment::find($id);
               return $this->responseService->success_response($comment);
           }
           else
           {
               return $this->responseService->unauthorized_response();
           }
       }

       ////////////////////////////////////////////////////////////////////// Store a new Comment:
       public function store(CreateCommentRequest $request)
       {
           if($request->user()->can('create.comment'))
           {
               $comment = Comment::create($request->toArray());
               return $this->responseService->success_response($comment);
           }
           else
           {
               return $this->responseService->unauthorized_response();
           }
       }

       ///////////////////////////////////////////////////////////////////////// Update comment:
       public function update(UpdateCommentRequest $request, string $id)
       {
           if($request->user()->can('update.comment'))
           {
               $comment = Comment::find($id)->update($request->toArray());
               return $this->responseService->success_response($comment);
           }
           else
           {
               return $this->responseService->unauthorized_response();
           }
       }

       //////////////////////////////////////////////////////////////////////// Destroy comment:
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
