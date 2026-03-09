<?php

namespace App\Http\Resources\Api\v1\Chat;

use App\Http\Resources\Api\v1\User\UserResource;
use App\Models\Chat\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Message */
class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user_id' => $this->user_id,
            'parent_id' => $this->parent_id,

            'user' => new UserResource($this->whenLoaded('user')),
            'parent' => new MessageResource($this->whenLoaded('parent')),
        ];
    }
}
