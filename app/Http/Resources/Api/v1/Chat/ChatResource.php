<?php

namespace App\Http\Resources\Api\v1\Chat;

use App\Http\Resources\Api\v1\User\UserResource;
use App\Models\Chat\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Chat */
class ChatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'chat_participants' => ChatParticipantResource::collection($this->whenLoaded('chatParticipants')),
        ];
    }
}
