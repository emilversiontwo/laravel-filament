<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\v1\Auth;

use App\Enums\User\UserGenderEnum;
use App\Services\Auth\Dto\RegistrationAuthDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegistrationAuthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nickname' => ['sometimes', 'string', 'max:255'],
            'gender' => ['required', 'string', Rule::enum(UserGenderEnum::class)],
            'birthday' => ['required', 'date'],
            'best_friend_name' => ['required', 'string', 'max:255'],
            'user_type_id' => ['required', 'integer', 'exists:user_types,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): RegistrationAuthDto
    {
        $data = $this->validated();

        return new RegistrationAuthDto([
            ...$data,
            'token_name' => $this->device_name ?? $this->userAgent() ?? Str::random(20),
        ]);
    }
}
