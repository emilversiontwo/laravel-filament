<?php

namespace App\Http\Requests\Api\v1\ChatParticipant;

use App\Enums\ChatParticipant\ChatParticipantRoleEnum;
use App\Services\ChatParticipant\Dto\StoreChatParticipantDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChatParticipantRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'role' => ['required', 'string', Rule::enum(ChatParticipantRoleEnum::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(int $chat_id): StoreChatParticipantDto
    {
        $data = $this->validated();

        return new StoreChatParticipantDto([
            ...$data,
            'user_id_acting_as' => $this->user()->id,
            'chat_id' => $chat_id,
        ]);
    }
}
