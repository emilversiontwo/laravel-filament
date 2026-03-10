<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\v1\Friendship;

use App\Enums\Friendship\FriendshipTypeSortEnum;
use App\Services\Friendship\Dto\IndexFriendshipDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexFriendshipRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type_sort' => ['sometimes', 'string', Rule::enum(FriendshipTypeSortEnum::class)],
            'per_page' => ['sometimes', 'integer', 'min:1'],
            'page' => ['sometimes', 'integer', 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): IndexFriendshipDto
    {
        $data = $this->validated();

        return new IndexFriendshipDto([
            ...$data,
            'per_page' => intval($data['per_page']),
            'page' => intval($data['page']),
            'user_id' => $this->user()->id,
        ]);
    }
}
