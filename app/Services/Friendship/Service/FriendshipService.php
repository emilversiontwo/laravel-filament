<?php

namespace App\Services\Friendship\Service;

use App\Enums\Friendship\FriendshipStatusEnum;
use App\Exceptions\AppLogicException;
use App\Models\Friendship;
use App\Models\User;
use App\Services\Friendship\Dto\FriendshipDto;
use App\Services\Friendship\Dto\IndexFriendshipDto;
use App\Services\Friendship\Dto\StoreFriendshipDto;
use App\Services\Friendship\Dto\UpdateFriendshipDto;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class FriendshipService
{
    public function index(IndexFriendshipDto $dto): LengthAwarePaginator
    {
        $friendships = Friendship::query();

        $friendships->when($dto->type_sort, function ($query) use ($dto) {
            if ($dto->type_sort == 'my') {
                $query->where('user_id', $dto->user_id);
            }
            if ($dto->type_sort == 'other') {
                $query->where('friend_user_id', $dto->user_id);
            }
        });

        return $friendships->paginate(perPage: $dto->per_page, page: $dto->page);
    }

    /**
     * @throws AppLogicException
     */
    public function store(StoreFriendshipDto $dto): Friendship
    {
        if ($dto->user_id == $dto->friend_user_id) {
            throw new AppLogicException('You cannot add yourself.', ResponseCode::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::query()->findOrFail($dto->user_id);
        $userFriend = User::query()->findOrFail($dto->friend_user_id);


        if (Friendship::query()->where('user_id', $dto->user_id)->where('friend_user_id', $userFriend->id)->exists()) {
            throw new AppLogicException('Friendship already exists', ResponseCode::HTTP_UNPROCESSABLE_ENTITY);
        }

        $friendship = new Friendship();

        $friendship->user_id = $user->id;
        $friendship->friend_user_id = $userFriend->id;
        $friendship->status = FriendshipStatusEnum::PENDING->getValue();

        $friendship->save();

        return $friendship;
    }

    /**
     * @throws AppLogicException
     */
    public function update(UpdateFriendshipDto $dto): Friendship
    {
        $friendship = Friendship::query()->with('friendUser')->with('user')->findOrFail($dto->friendship_id);

        $friendshipStatus = FriendshipStatusEnum::tryFromString($dto->status);

        if ($friendshipStatus == FriendshipStatusEnum::ACCEPTED && $friendship->friend_user_id !== $dto->user_id) {
            throw AppLogicException::forbidden();
        }

        $friendship->status = $friendshipStatus->getValue();

        $friendship->save();

        return $friendship;
    }

    /**
     * @throws AppLogicException
     */
    public function show(FriendshipDto $dto): Friendship
    {
        $friendship = Friendship::query()->with('friendUser')->with('user')->findOrFail($dto->friendship_id);

        if ($friendship->friend_user_id !== $dto->user_id && $friendship->user_id !== $dto->user_id) {
            throw AppLogicException::forbidden();
        }

        return $friendship;
    }

    /**
     * @throws AppLogicException
     */
    public function destroy(FriendshipDto $dto): void
    {
        $friendship = Friendship::query()->findOrFail($dto->friendship_id);

        if ($dto->user_id !== $friendship->user_id) {
            throw AppLogicException::forbidden();
        }

        $friendship->delete();
    }
}
