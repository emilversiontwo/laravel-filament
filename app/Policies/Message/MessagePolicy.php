<?php

namespace App\Policies\Message;

use App\Enums\ChatParticipant\ChatParticipantRoleEnum;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;

class MessagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Chat $chat): bool
    {
        return $this->isChatHasUser($user, $chat);
    }

    public function isChatHasUser(User $user, Chat $chat): bool
    {
        return $chat->whereHas('chatParticipants', function (Builder $query) use ($user, $chat) {
            $query->where('user_id', $user->id);
            $query->where('chat_id', $chat->id);
        })->exists();
    }

    public function view(User $user, Message $message, Chat $chat): bool
    {
        return $this->isChatHasUser($user, $chat);
    }

    public function create(User $user, Chat $chat): bool
    {
        return $this->isChatHasUser($user, $chat);
    }

    public function update(User $user, Message $message, Chat $chat): bool
    {
        return $user->id === $message->user_id && $this->isChatHasUser($user, $chat);
    }

    public function delete(User $user, Message $message, Chat $chat ): bool
    {
        return $user->id === $message->user_id || $chat->whereHas('chatParticipants', function (Builder $query) use ($user, $chat) {
                $query->where('user_id', $user->id);
                $query->where('chat_id', $chat->id);
                $query->where('type', ChatParticipantRoleEnum::ADMIN->getValue());
            });
    }
}
