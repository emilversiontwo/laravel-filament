<?php

namespace App\Http\Resources\Api\v1\Friendship;

use App\Http\Resources\Api\v1\User\UserResource;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Friendship */
class FriendshipResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user_id' => $this->user_id,
            'friend_user_id' => $this->friend_user_id,

            'user' => new UserResource($this->whenLoaded('user')),
            'friendUser' => new UserResource($this->whenLoaded('friendUser')),
        ];
    }
}
