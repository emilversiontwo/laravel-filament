<?php

namespace App\Http\Controllers\Api\v1\Friendship;

use App\Exceptions\AppLogicException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Friendship\IndexFriendshipRequest;
use App\Http\Requests\Api\v1\Friendship\StoreFriendshipRequest;
use App\Http\Requests\Api\v1\Friendship\UpdateFriendshipRequest;
use App\Http\Resources\Api\v1\Friendship\FriendshipResource;
use App\Models\Friendship;
use App\Services\Friendship\Dto\FriendshipDto;
use App\Services\Friendship\Service\FriendshipService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class FriendshipController extends Controller
{
    public function __construct(
        private readonly FriendshipService $friendshipService
    )
    {}

    public function index(IndexFriendshipRequest $request): JsonResponse
    {
        $dto = $request->toDto();

        $friendships = $this->friendshipService->index($dto);

        return FriendshipResource::collection($friendships)->response()->setStatusCode(ResponseCode::HTTP_OK);
    }

    /**
     * @throws AppLogicException
     */
    public function store(StoreFriendshipRequest $request): JsonResponse
    {
        $dto = $request->toDto();

        $friendship = $this->friendshipService->store($dto);

        return FriendshipResource::make($friendship)->response()->setStatusCode(ResponseCode::HTTP_CREATED);
    }

    /**
     * @throws AppLogicException
     */
    public function show(Request $request, Friendship $friendship): JsonResponse
    {
        $dto = new FriendshipDto([
            'user_id' => $request->user()->id,
            'friendship_id' => $friendship->id,
        ]);

        $friendship = $this->friendshipService->show($dto);

        return FriendshipResource::make($friendship)->response()->setStatusCode(ResponseCode::HTTP_OK);
    }

    /**
     * @throws AppLogicException
     */
    public function update(UpdateFriendshipRequest $request, Friendship $friendship): JsonResponse
    {
        $dto = $request->toDto($friendship->id);

        $friendship = $this->friendshipService->update($dto);

        return FriendshipResource::make($friendship)->response()->setStatusCode(ResponseCode::HTTP_OK);
    }

    /**
     * @throws AppLogicException
     */
    public function destroy(Request $request, Friendship $friendship): Response
    {
        $dto = new FriendshipDto([
            'user_id' => $request->user()->id,
            'friendship_id' => $friendship->id,
        ]);

        $this->friendshipService->destroy($dto);

        return response()->noContent()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }
}
