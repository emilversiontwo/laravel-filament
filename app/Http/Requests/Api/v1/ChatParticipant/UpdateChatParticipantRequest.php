<?php

namespace App\Http\Requests\Api\v1\ChatParticipant;

use App\Enums\ChatParticipant\ChatParticipantRoleEnum;
use App\Services\ChatParticipant\Dto\ChatParticipantDto;
use App\Services\ChatParticipant\Dto\UpdateChatParticipantDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChatParticipantRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role' => ['required', Rule::enum(ChatParticipantRoleEnum::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(int $participant_id): UpdateChatParticipantDto
    {
        $data = $this->validated();

        return new UpdateChatParticipantDto([
            ...$data,
            'participant_id' => $participant_id,
        ]);
    }
}
