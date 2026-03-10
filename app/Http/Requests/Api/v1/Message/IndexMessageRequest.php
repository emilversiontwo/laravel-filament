<?php

namespace App\Http\Requests\Api\v1\Message;

use App\Services\Message\Dto\IndexMessageDto;
use Illuminate\Foundation\Http\FormRequest;

class IndexMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'exists:users,id'],
            'body' => ['sometimes', 'string'],
            'per_page' => ['sometimes', 'integer', 'min:1'],
            'page' => ['sometimes', 'integer', 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(int $chat_id): IndexMessageDto
    {
        $data = $this->validated();

        return new IndexMessageDto([
            ...$data,
            'user_id' => intval($data['user_id'] ?? null),
            'per_page' => intval($data['per_page'] ?? null),
            'page' => intval($data['page'] ?? null),
            'chat_id' => $chat_id,
        ]);
    }
}
