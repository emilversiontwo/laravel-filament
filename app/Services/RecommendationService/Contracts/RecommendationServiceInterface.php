<?php

namespace App\Services\RecommendationService\Contracts;

use App\Services\RecommendationService\Dto\RecommendationDto;
use Illuminate\Support\Collection;

interface RecommendationServiceInterface
{
    public function getSuggestions(RecommendationDto $dto): Collection;
}
