<?php

namespace App\Http\Requests\Api\v1\Chat;

use App\Enums\Chat\ChatTypeEnum;
use App\Services\Chat\Dto\ChatDto;
use App\Services\Chat\Dto\IndexChatDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexChatRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['sometimes', 'string', Rule::enum(ChatTypeEnum::class)],
            'title' => ['sometimes', 'string'],
            'per_page' => ['sometimes', 'integer', 'min:1'],
            'page' => ['sometimes', 'integer', 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): IndexChatDto
    {
        $data = $this->validated();

        return new IndexChatDto([
            ...$data,
            'per_page' => intval($data['per_page']),
            'page' => intval($data['page']),
            'user_id' => $this->user()->id,
        ]);
    }
}
