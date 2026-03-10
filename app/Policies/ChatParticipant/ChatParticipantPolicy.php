<?php

namespace App\Policies\ChatParticipant;

use App\Enums\Chat\ChatTypeEnum;
use App\Enums\ChatParticipant\ChatParticipantRoleEnum;
use App\Models\Chat\Chat;
use App\Models\Chat\ChatParticipant;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ChatParticipantPolicy
{
    public function create(User $user, Chat $chat): bool
    {
        return $this->isChatAdmin($user, $chat);
    }

    public function update(User $user, ChatParticipant $chatParticipant): bool
    {
        $chat = $chatParticipant->chat()->first();

        return $this->isChatAdmin($user, $chat);
    }

    public function delete(User $user, ChatParticipant $chatParticipant): bool
    {
        $chat = $chatParticipant->chat()->first();

        return $this->isChatAdmin($user, $chat) || $user->id === $chatParticipant->user_id;
    }

    private function isChatAdmin(User $user, Chat $chat): bool
    {
        $chatType = ChatTypeEnum::tryFromString($chat->type);

        if ($chatType == ChatTypeEnum::GROUP){
            return $chat->whereHas('chatParticipants', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id);
                $query->where('role', '=', ChatParticipantRoleEnum::ADMIN->getValue());
            })->exists();
        } else {
            return $chat->whereHas('chatParticipants', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id);
            })->exists();
        }
    }
}
