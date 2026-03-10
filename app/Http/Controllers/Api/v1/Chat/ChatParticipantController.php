<?php

namespace App\Http\Controllers\Api\v1\Chat;

use App\Exceptions\AppLogicException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ChatParticipant\StoreChatParticipantRequest;
use App\Http\Requests\Api\v1\ChatParticipant\UpdateChatParticipantRequest;
use App\Http\Resources\Api\v1\Chat\ChatParticipantResource;
use App\Models\Chat\Chat;
use App\Models\Chat\ChatParticipant;
use App\Services\ChatParticipant\Dto\ChatParticipantDto;
use App\Services\ChatParticipant\Service\ChatParticipantService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class ChatParticipantController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly ChatParticipantService $chatParticipantService
    )
    {
    }

    /**
     * @throws AppLogicException
     */
    public function store(StoreChatParticipantRequest $request, Chat $chat): JsonResponse
    {
        $dto = $request->toDto($chat->id);

        $this->authorize('create', [ChatParticipant::class, $chat]);

        $chatParticipant = $this->chatParticipantService->store($dto);

        return ChatParticipantResource::make($chatParticipant)->response()->setStatusCode(ResponseCode::HTTP_CREATED);
    }

    public function update(UpdateChatParticipantRequest $request, Chat $chat, string $chat_participant_id)
    {
        $chatParticipant = ChatParticipant::query()->findOrFail(intval($chat_participant_id));

        $dto = $request->toDto($chatParticipant->id);

        $this->authorize('update', $chatParticipant);

        $chatParticipant = $this->chatParticipantService->update($dto);

        return ChatParticipantResource::make($chatParticipant)->response()->setStatusCode(ResponseCode::HTTP_OK);
    }

    public function destroy(Chat $chat, string $chat_participant_id)
    {
        $chatParticipant = ChatParticipant::query()->findOrFail(intval($chat_participant_id));

        $dto = new ChatParticipantDto([
            'participant_id' => $chatParticipant->id,
        ]);

        $this->authorize('delete', $chatParticipant);

        $this->chatParticipantService->destroy($dto);

        return response()->noContent()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }
}
