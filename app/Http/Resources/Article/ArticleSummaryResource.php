<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Media\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleSummaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'main_image' => MediaResource::collection($this->getMedia('main_image')),
        ];
    }
}
