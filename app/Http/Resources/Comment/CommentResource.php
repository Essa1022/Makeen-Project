<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\Like\LikeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'article_id' => $this->article_id,
          'comment_id' => $this->comment_id,
          'name' => $this->name,
          'message' => $this->message,
          'status' => $this->status,
          'likes_count' => $this->likes->where('type', 'like')->count(),
          'dislikes_count' => $this->likes->where('type', 'dislike')->count(),
          'replies' => CommentResource::collection($this->whenLoaded('replies')),
        ];
    }
}
