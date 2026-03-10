<?php

namespace App\Http\Requests\Api\v1\Message;

use App\Services\Message\Dto\StoreMessageDto;
use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'exists:messages,id'],
            'body' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(int $chat_id): StoreMessageDto
    {
        $data = $this->validated();

        return new StoreMessageDto([
            ...$data,
            'parent_id' => intval($data['parent_id'] ?? null),
            'chat_id' => $chat_id,
            'user_id' => $this->user()->id,
        ]);
    }
}
