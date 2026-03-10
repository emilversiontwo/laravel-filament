<?php

namespace App\Http\Controllers\Api\v1\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Message\IndexMessageRequest;
use App\Http\Requests\Api\v1\Message\StoreMessageRequest;
use App\Http\Requests\Api\v1\Message\UpdateMessageRequest;
use App\Http\Resources\Api\v1\Chat\MessageResource;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use App\Services\Message\Dto\MessageDto;
use App\Services\Message\Service\MessageService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class MessageController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly MessageService $messageService,
    )
    {
    }

    public function index(IndexMessageRequest $request, Chat $chat): JsonResponse
    {
        $dto = $request->toDto($chat->id);

        $this->authorize('viewAny', [Message::class, $chat]);

        $messages = $this->messageService->index($dto);

        return MessageResource::collection($messages)->response()->setStatusCode(ResponseCode::HTTP_OK);
    }

    public function store(StoreMessageRequest $request, Chat $chat): JsonResponse
    {
        $dto = $request->toDto($chat->id);

        $this->authorize('create', [Message::class, $chat]);

        $message = $this->messageService->store($dto);

        return MessageResource::make($message)->response()->setStatusCode(ResponseCode::HTTP_CREATED);
    }

    public function show(Chat $chat, int $message_id)
    {
        $message = Message::query()->findOrFail($message_id);

        $dto = new MessageDto([
            'message_id' => $message->id,
        ]);

        $this->authorize('view', [$message, $chat]);

        $message = $this->messageService->show($dto);

        return MessageResource::make($message)->response()->setStatusCode(ResponseCode::HTTP_OK);
    }

    public function update(UpdateMessageRequest $request, Chat $chat, int $message_id)
    {
        $message = Message::query()->findOrFail($message_id);

        $dto = $request->toDto($message->id);

        $this->authorize('update', [$message, $chat]);

        $message = $this->messageService->update($dto);

        return MessageResource::make($message)->response()->setStatusCode(ResponseCode::HTTP_OK);
    }

    public function destroy(Chat $chat, int $message_id)
    {
        $message = Message::query()->findOrFail($message_id);

        $dto = new MessageDto([
            'message_id' => $message->id,
        ]);

        $this->authorize('delete', [$message, $chat]);

        $this->messageService->destroy($dto);

        return response()->noContent()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }
}
