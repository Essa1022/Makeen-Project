<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Media\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'username' => $this->username,
          'phone_number' => $this->phone_number,
          'password' => $this->password,
          'avatar_image' => MediaResource::collection($this->getMedia('avatar'))
        ];
    }
}
