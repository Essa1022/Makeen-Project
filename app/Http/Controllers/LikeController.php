<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Store a new Like
    public function store(LikeRequest $request, Comment $comment)
    {
        $type = $request->input('type');
        $ip_address = $request->ip();

        $like = Like::create([
            'comment_id' => $comment->id,
            'ip_address' => $ip_address,
            'type' => $type,
        ]);
        return $this->responseService->success_response($like);
    }

    // Update Like
    public function update(LikeRequest $request, Comment $comment)
    {
        $type = $request->input('type');
        $ip_address = $request->ip();
        $like = Like::where('comment_id', $comment->id)
            ->where('ip_address', $ip_address)
            ->first();
        if ($like)
        {
        $like->update(['type' => $type,]);
        return $this->responseService->success_response($like);
        }
    }

    // Delete Like
    public function delete(LikeRequest $request, Comment $comment)
    {
        $type = $request->input('type');
        $ip_address = $request->ip();
        $like = Like::where('comment_id', $comment->id)
            ->where('ip_address', $ip_address)
            ->first();
        if($like && $like->type == $type)
        {
            $like->delete();
            return $this->responseService->delete_response();
        }
    }
}
