<?php
declare(strict_types=1);

namespace App\Services\User\Service;

use App\Enums\User\UserGenderEnum;
use App\Models\User;
use App\Models\UserType;
use App\Services\User\Dto\StoreUserDto;
use App\Services\User\Dto\UpdateUserDto;
use App\Services\User\Dto\UserIdDto;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{

    /**
     * Get all users
     * @return Collection
     */
    public function index(): Collection
    {
        return User::query()->get();
    }

    /**
     * Crate new user
     * @param StoreUserDto $dto
     * @return User
     */
    public function store(StoreUserDto $dto): User
    {
        $userType = UserType::query()->findOrFail($dto->user_type_id);

        $user = new User();

        $user->email = $dto->email;
        $user->password = Hash::make($dto->password);
        $user->name = $dto->name;
        $user->nickname = $dto->nickname;
        $user->gender = UserGenderEnum::tryFromString($dto->gender)->getValue();
        $user->birthday = Carbon::parse($dto->birthday);
        $user->best_friend_name = $dto->best_friend_name;
        $user->user_type_id = $userType->id;

        $user->save();

        return $user;
    }

    /**
     * Update user
     * @param UpdateUserDto $dto
     * @return User
     */
    public function update(UpdateUserDto $dto): User
    {
        $user = User::query()->findOrFail($dto->user_id);

        if ($dto->name) {
            $user->name = $dto->name;
        }

        if ($dto->email) {
            $user->email = $dto->email;
        }

        if (!empty($dto->password)) {
            $user->password = Hash::make($dto->password);
        }

        if ($dto->nickname) {
            $user->nickname = $dto->nickname;
        }

        if ($dto->gender) {
            $user->gender = UserGenderEnum::tryFromString($dto->gender)->getValue();
        }

        if ($dto->birthday) {
            $user->birthday = Carbon::parse($dto->birthday);
        }

        if ($dto->best_friend_name) {
            $user->best_friend_name = $dto->best_friend_name;
        }

        if ($dto->user_type_id) {
            $userType = UserType::query()->findOrFail($dto->user_type_id);
            $user->user_type_id = $userType;
        }

        $user->save();

        return $user;
    }

    /**
     * Delete user
     * @param UserIdDto $dto
     * @return void
     */
    public function destroy(UserIdDto $dto): void
    {
        $user = User::query()->findOrFail($dto->user_id);
        $user->delete();
    }

    /**
     * Show user
     * @param UserIdDto $dto
     * @return User
     */
    public function show(UserIdDto $dto): User
    {
        return User::query()->findOrFail($dto->user_id);
    }
}
