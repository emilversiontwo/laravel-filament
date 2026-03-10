<?php

namespace App\Http\Requests\Api\v1\Message;

use App\Services\Message\Dto\MessageDto;
use App\Services\Message\Dto\UpdateMessageDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['sometimes', 'exists:messages,id'],
            'body' => ['sometimes', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto($message_id): UpdateMessageDto
    {
        $data = $this->validated();

        return new UpdateMessageDto([
            ...$data,
            'message_id' => $message_id,
        ]);
    }
}
