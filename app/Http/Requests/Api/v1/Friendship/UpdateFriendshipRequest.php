<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\v1\Friendship;

use App\Enums\Friendship\FriendshipStatusEnum;
use App\Services\Friendship\Dto\UpdateFriendshipDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFriendshipRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', Rule::enum(FriendshipStatusEnum::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(int $friendship_id): UpdateFriendshipDto
    {
        $data = $this->validated();

        return new UpdateFriendshipDto([
            ...$data,
            'friendship_id' => $friendship_id,
            'user_id' => $this->user()->id,
        ]);
    }
}
