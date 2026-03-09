<?php

namespace App\Http\Requests\Api\v1\Chat;

use App\Services\Chat\Dto\UpdateChatDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateChatRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(int $chat_id): UpdateChatDto
    {
        $data = $this->validated();

        return new UpdateChatDto([
            ...$data,
            'user_id' => $this->user()->id,
            'chat_id' => $chat_id,
        ]);
    }
}
