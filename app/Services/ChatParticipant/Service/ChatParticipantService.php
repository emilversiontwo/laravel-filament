<?php

namespace App\Services\ChatParticipant\Service;

use App\Enums\Chat\ChatTypeEnum;
use App\Enums\ChatParticipant\ChatParticipantRoleEnum;
use App\Exceptions\AppLogicException;
use App\Models\Chat\Chat;
use App\Models\Chat\ChatParticipant;
use App\Services\ChatParticipant\Dto\ChatParticipantDto;
use App\Services\ChatParticipant\Dto\StoreChatParticipantDto;
use App\Services\ChatParticipant\Dto\UpdateChatParticipantDto;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class ChatParticipantService
{
    /**
     * @throws AppLogicException
     */
    public function store(StoreChatParticipantDto $dto): ChatParticipant
    {
        if (
            ChatParticipant::query()
            ->where('chat_id', '=', $dto->chat_id)
            ->where('user_id', '=', $dto->user_id)
                ->exists()
        ) {
            throw new AppLogicException('You already have a ChatParticipant', ResponseCode::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (
            ChatParticipant::query()
                ->where('chat_id', '=', $dto->chat_id)
                ->count() > 1
            &&
            ChatTypeEnum::tryFromString(
                Chat::query()
                    ->findOrFail($dto->chat_id)
                    ->type
            ) === ChatTypeEnum::PERSONAL
        ) {
            throw new AppLogicException('You cannot add user to chat because its personal chat' , ResponseCode::HTTP_UNPROCESSABLE_ENTITY);
        }

        $chatParticipant = new ChatParticipant();

        $chatParticipant->chat_id = $dto->chat_id;
        $chatParticipant->user_id = $dto->user_id;
        $chatParticipant->role = ChatParticipantRoleEnum::tryFromString($dto->role)->getValue();

        $chatParticipant->save();

        return $chatParticipant;
    }

    public function update(UpdateChatParticipantDto $dto): ChatParticipant
    {
        $chatParticipant = ChatParticipant::query()->findOrFail($dto->participant_id);

        $chatParticipant->role = ChatParticipantRoleEnum::tryFromString($dto->role)->getValue();

        $chatParticipant->save();

        return $chatParticipant;
    }

    public function destroy(ChatParticipantDto $dto): void
    {
        $chatParticipant = ChatParticipant::query()->findOrFail($dto->participant_id);

        $chatParticipant->delete();
    }
}
