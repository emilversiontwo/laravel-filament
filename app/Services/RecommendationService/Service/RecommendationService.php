<?php

namespace App\Services\RecommendationService\Service;

use App\Enums\User\UserGenderEnum;
use App\Models\User;
use App\Services\RecommendationService\Contracts\RecommendationServiceInterface;
use App\Services\RecommendationService\Dto\RecommendationDto;
use Illuminate\Support\Collection;

class RecommendationService implements RecommendationServiceInterface
{
    public function getSuggestions(RecommendationDto $dto): Collection
    {
        $user = User::query()->findOrFail($dto->user_id);

        $exceptUserIds = $user->friendships()->get()->pluck('friend_user_id')->toArray();
        array_push($exceptUserIds, $user->id);

        $candidates = collect();

        $oppositeGender = UserGenderEnum::tryFromString($user->gender)->oppositeGender()->getValue();

        $users = User::query()
            ->where('user_type_id', '=', $user->user_type_id)
            ->whereNotIn('id', $exceptUserIds)
            ->orderByRaw("CASE WHEN gender = ? THEN 0 ELSE 1 END", [$oppositeGender])
            ->limit($dto->limit)
            ->offset($dto->offset)
            ->get();

        $candidates->merge($this->findSimilarNames($user->best_friend_name, $users, $dto->limit));

        if ($candidates->count() >= $dto->limit) {
            return $candidates;
        }

        $candidates->merge($this->findSimilarNicknames($user->best_friend_name, $users, $dto->limit));

        if ($candidates->count() >= $dto->limit) {
            return $candidates;
        }

        foreach ($users as $user) {
            if ($candidates->count() <= $dto->limit) {
                if (!$candidates->where('id', $user->id)->isNotEmpty())
                {
                    $candidates->push($user);
                }
            } else {
                break;
            }
        }

        return $candidates;
    }

    private function findSimilarNames(string $best_friend_name, $users, $limit = 10): Collection
    {
        $candidates = collect();

        foreach ($users as $user) {
            /** @var User $user */
            if (similar_text($best_friend_name, $user->name) >= 60) {
                $candidates->push($user);
            }

            if ($candidates->count() >= $limit) {
                return $candidates;
            }
        }

        return $candidates;
    }

    private function findSimilarNicknames(string $best_friend_name, Collection $users, $limit = 10): Collection
    {
        $candidates = collect();

        foreach ($users as $user) {
            /** @var User $user */
            if (similar_text($best_friend_name, $user->nickname) >= 60) {
                if (!$candidates->has($user)) {
                    $candidates->push($user);
                }
            }

            if ($candidates->count() >= $limit) {
                return $candidates;
            }
        }

        return $candidates;
    }
}
