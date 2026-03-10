<?php

namespace App\Policies\Chat;

use App\Enums\Chat\ChatTypeEnum;
use App\Enums\ChatParticipant\ChatParticipantRoleEnum;
use App\Models\Chat\Chat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;

class ChatPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Chat $chat): bool
    {
        return $chat->whereHas('chatParticipants', function (Builder $query) use ($chat, $user) {
            $query->where('chat_id', $chat->id);
            $query->where('user_id', $user->id);
        })->exists();
    }

    public function update(User $user, Chat $chat): bool
    {
        return $this->isChatAdmin($user, $chat);
    }

    public function delete(User $user, Chat $chat): bool
    {
        return $this->isChatAdmin($user, $chat);
    }

    private function isChatAdmin(User $user, Chat $chat): bool
    {
        $chatType = ChatTypeEnum::tryFromString($chat->type);

        if ($chatType == ChatTypeEnum::GROUP) {
            return $chat->whereHas('chatParticipants', function (Builder $query) use ($chat, $user) {
                $query->where('chat_id', $chat->id);
                $query->where('user_id', $user->id);
                $query->where('role', ChatParticipantRoleEnum::ADMIN->getValue());
            })->exists();
        } else {
            return $chat->whereHas('chatParticipants', function (Builder $query) use ($chat, $user) {
                $query->where('chat_id', $chat->id);
                $query->where('user_id', $user->id);
            })->exists();
        }
    }
}
