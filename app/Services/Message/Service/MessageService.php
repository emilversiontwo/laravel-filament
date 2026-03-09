<?php

namespace App\Services\Message\Service;

use App\Models\Chat\Message;
use App\Services\Message\Dto\IndexMessageDto;
use App\Services\Message\Dto\MessageDto;
use App\Services\Message\Dto\StoreMessageDto;
use App\Services\Message\Dto\UpdateMessageDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class MessageService
{
    public function index(IndexMessageDto $dto): LengthAwarePaginator
    {
        $messages = Message::query();

        $messages->where('chat_id', $dto->chat_id);

        $messages->when($dto->body, function (Builder $query) use ($dto) {
            $query->where('body', 'like', '%' . $dto->body . '%');
        });

        $messages->when($dto->user_id, function (Builder $query) use ($dto) {
            $query->where('user_id', $dto->user_id);
        });

        return $messages->paginate(perPage: $dto->per_page, page: $dto->page);
    }

    public function store(StoreMessageDto $dto): Message
    {
        $message = new Message();

        $message->body = $dto->body;
        $message->parent_id = $dto->parent_id;

        $message->chat()->associate($dto->chat_id);
        $message->user()->associate($dto->user_id);

        $message->save();

        return $message;
    }

    public function show(MessageDto $dto): Message
    {
        return Message::query()->with('parent')->findOrFail($dto->message_id);
    }

    public function update(UpdateMessageDto $dto): Message
    {
        $message = Message::query()->findOrFail($dto->message_id);

        if ($dto->body) {
            $message->body = $dto->body;
        }

        $message->save();

        return $message;
    }

    public function destroy(MessageDto $dto): void
    {
        $message = Message::query()->findOrFail($dto->message_id);

        $message->delete();
    }
}
