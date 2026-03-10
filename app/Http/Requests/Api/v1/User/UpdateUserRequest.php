<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\v1\User;

use App\Enums\User\UserGenderEnum;
use App\Services\User\Dto\UpdateUserDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users'],
            'nickname' => ['sometimes', 'string', 'max:255'],
            'gender' => ['sometimes', 'string', Rule::enum(UserGenderEnum::class)],
            'birthday' => ['sometimes', 'date'],
            'best_friend_name' => ['sometimes', 'string', 'max:255'],
            'user_type_id' => ['sometimes', 'integer', 'exists:user_types,id'],
            'password' => ['sometimes', 'string', 'min:8'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(int $user_id): UpdateUserDto
    {
        $data = $this->validated();

        return new UpdateUserDto([
            ...$data,
            'user_id' => $user_id,
        ]);
    }
}
