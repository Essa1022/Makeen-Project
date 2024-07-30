<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\Media\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'slug' => $this->slug,
            'views' => $this->views,
            'main_image' => MediaResource::collection($this->getMedia('main_image')),
            'second_image' => MediaResource::collection($this->getMedia('second_image')),
        ];
    }
}
