<?php

namespace App\Http\Controllers\Api\v1\Chat;

use App\Enums\Chat\ChatTypeEnum;
use App\Enums\ChatParticipant\ChatParticipantRoleEnum;
use App\Exceptions\AppLogicException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Chat\IndexChatRequest;
use App\Http\Requests\Api\v1\Chat\StoreChatRequest;
use App\Http\Requests\Api\v1\Chat\UpdateChatRequest;
use App\Http\Resources\Api\v1\Chat\ChatResource;
use App\Models\Chat\Chat;
use App\Services\Chat\Dto\ChatDto;
use App\Services\Chat\Service\ChatService;
use App\Services\ChatParticipant\Dto\StoreChatParticipantDto;
use App\Services\ChatParticipant\Service\ChatParticipantService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class ChatController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly ChatService            $chatService,
        private readonly ChatParticipantService $chatParticipantService,
    )
    {
    }

    public function index(IndexChatRequest $request): JsonResponse
    {
        $dto = $request->toDto();

        $chats = $this->chatService->index($dto);

        return ChatResource::collection($chats)->response()->setStatusCode(ResponseCode::HTTP_OK);
    }

    /**
     * @throws AppLogicException
     */
    public function store(StoreChatRequest $request): JsonResponse
    {
        $dto = $request->toDto();

        $chat = $this->chatService->store($dto);

        $chatType = ChatTypeEnum::tryFromString($dto->type);

        $data = [
            'chat_id' => $chat->id,
            'user_id' => $request->user()->id,
        ];

        if ($chatType == ChatTypeEnum::GROUP) {
            $data['role'] = ChatParticipantRoleEnum::ADMIN->getValue();
        } else {
            $data['role'] = ChatParticipantRoleEnum::MEMBER->getValue();
        }

        $dto = new StoreChatParticipantDto($data);

        $this->chatParticipantService->store($dto);

        return ChatResource::make($chat)->response()->setStatusCode(ResponseCode::HTTP_CREATED);
    }

    public function show(Chat $chat): JsonResponse
    {
        $dto = new ChatDto([
            'chat_id' => $chat->id,
        ]);

        $this->authorize('view', $chat);

        $chat = $this->chatService->show($dto);

        return ChatResource::make($chat)->response()->setStatusCode(ResponseCode::HTTP_OK);
    }

    public function update(UpdateChatRequest $request, Chat $chat): JsonResponse
    {
        $dto = $request->toDto($chat->id);

        $this->authorize('update', $chat);

        $chat = $this->chatService->update($dto);

        return ChatResource::make($chat)->response()->setStatusCode(ResponseCode::HTTP_OK);
    }

    public function destroy(Chat $chat, Request $request)
    {
        $dto = new ChatDto([
            'user_id' => $request->user()->id,
            'chat_id' => $chat->id,
        ]);

        $this->authorize('delete', $chat);

        $this->chatService->destroy($dto);

        return response()->noContent()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }
}
