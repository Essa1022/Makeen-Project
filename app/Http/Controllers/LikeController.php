<?php

namespace App\Http\Controllers;

use App\Http\Requests\Like\LikeRequest;
use App\Http\Requests\Like\LikeRequest as LikeLikeRequest;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(LikeRequest $request, Comment $comment)
    {
        $type = $request->input('type');
        $ip_address = $request->ip();
        $existing_like = Like::where('comment_id', $comment->id)
            ->where('ip_address', $ip_address)
            ->first();
        if($existing_like)
        {
            if($existing_like->type == $type)
            {
                $existing_like->delete();
                return $this->responseService->delete_response();
            }
            else
            {
                $existing_like->update(['type' => $type,]);
                return $this->responseService->success_response($existing_like);
            }
        }

        $like = Like::create([
            'comment_id' => $comment->id,
            'ip_address' => $ip_address,
            'type' => $type,
        ]);
        return $this->responseService->success_response($like);
    }
}
