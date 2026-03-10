<?php

namespace App\Http\Controllers\Api\v1\Recommendation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Recommendation\RecommendationRequest;
use App\Http\Resources\Api\v1\User\UserResource;
use App\Services\RecommendationService\Service\RecommendationService;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class RecommendationController extends Controller
{
    public function __construct(
        private readonly RecommendationService $recommendationService,
    )
    {
    }

    public function getSuggests(RecommendationRequest $request)
    {
        $dto = $request->toDto();

        $users = $this->recommendationService->getSuggestions($dto);

        return UserResource::collection($users)->response()->setStatusCode(ResponseCode::HTTP_OK);
    }
}
