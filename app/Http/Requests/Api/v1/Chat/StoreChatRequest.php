<?php

namespace App\Http\Requests\Api\v1\Chat;

use App\Enums\Chat\ChatTypeEnum;
use App\Helpers\Dto\Dto;
use App\Services\Chat\Dto\ChatDto;
use App\Services\Chat\Dto\StoreChatDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChatRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::enum(ChatTypeEnum::class)],
            'title' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): StoreChatDto
    {
        $data = $this->validated();

        return new StoreChatDto([
            ...$data,
            'user_id' => $this->user()->id,
        ]);
    }
}
