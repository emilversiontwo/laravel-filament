<?php

namespace App\Services\Chat\Service;

use App\Enums\Chat\ChatTypeEnum;
use App\Enums\ChatParticipant\ChatParticipantRoleEnum;
use App\Exceptions\AppLogicException;
use App\Models\Chat\Chat;
use App\Models\Chat\ChatParticipant;
use App\Services\Chat\Dto\ChatDto;
use App\Services\Chat\Dto\IndexChatDto;
use App\Services\Chat\Dto\StoreChatDto;
use App\Services\Chat\Dto\UpdateChatDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ChatService
{
    public function index(IndexChatDto $dto): LengthAwarePaginator
    {
        $chats = Chat::query();

        $chats->whereHas('chatParticipants', function (Builder $builder) use ($dto) {
            $builder->where('user_id', $dto->user_id);
        });

        $chats->when($dto->title ,function (Builder $query) use ($dto) {
            $query->where('title', 'like', "%{$dto->title}%");
        });

        $chats->when($dto->type ,function (Builder $query) use ($dto) {
            $query->where('type', $dto->type);
        });

        return $chats->paginate(perPage: $dto->per_page ?? 10, page: $dto->page ?? 1);
    }

    public function store(StoreChatDto $dto): Chat
    {
        $chat = new Chat();
        $chat->title = $dto->title;
        $chat->type = ChatTypeEnum::tryFromString($dto->type)->getValue();

        $chat->save();

        return $chat;
    }

    /**
     * @param UpdateChatDto $dto
     * @return Chat
     */
    public function update(UpdateChatDto $dto): Chat
    {
        $chat = Chat::query()->findOrFail($dto->chat_id);

        if ($dto->title ?? false) {
            $chat->title = $dto->title;
        }

        $chat->save();

        return $chat;
    }

    /**
     * @param ChatDto $dto
     * @return void
     */
    public function destroy(ChatDto $dto): void
    {
        $chat = Chat::query()->findOrFail($dto->chat_id);

        $chat->delete();
    }

    public function show(ChatDto $dto): Chat
    {
        return Chat::query()
            ->with('chatParticipants')
            ->findOrFail($dto->chat_id);
    }
}
