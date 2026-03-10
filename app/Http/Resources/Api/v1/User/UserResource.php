<?php
declare(strict_types=1);

namespace App\Http\Resources\Api\v1\User;

use App\Enums\User\UserGenderEnum;
use App\Http\Resources\Api\v1\UserType\UserTypeResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'nickname' => $this->nickname,
            'gender' => UserGenderEnum::tryFromString($this->gender)->value,
            'birthday' => $this->birthday,
            'best_friend_name' => $this->best_friend_name,
            'user_type' => UserTypeResource::make($this->userType()->first()),
        ];
    }
}
