<?php

namespace App\Services\RecommendationService\Dto;

use App\Helpers\Dto\Dto;

class RecommendationDto extends Dto
{
    public int $user_id;

    public int $limit = 10;

    public int $offset = 0;
}
