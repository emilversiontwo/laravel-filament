<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\v1\Friendship;

use App\Services\Friendship\Dto\StoreFriendshipDto;
use Illuminate\Foundation\Http\FormRequest;

class StoreFriendshipRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'friend_user_id' => ['required', 'exists:users,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): StoreFriendshipDto
    {
        $data = $this->validated();

        return new StoreFriendshipDto([
            ...$data,
            'user_id' => $this->user()->id,
        ]);
    }
}
