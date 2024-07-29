<?php

namespace App\Http\Resources\Ad;

use App\Http\Resources\Media\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
            'title' => $this->title,
            'link' => $this->link,
            'ad_place' => $this->ad_place,
            'starts_at' => $this->strats_at,
            'ends_at' => $this->ends_at,
            'status' => $this->status,
            'ad_image' => MediaResource::collection($this->getMedia('ads')),
        ];
    }
}
