<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\LoginAuthRequest;
use App\Http\Requests\Api\v1\Auth\LogoutAuthRequest;
use App\Http\Requests\Api\v1\Auth\RegistrationAuthRequest;
use App\Http\Resources\Api\v1\Auth\AuthResource;
use App\Services\Auth\Dto\StoreTokenAuthDto;
use App\Services\Auth\Dto\UserIdAuthDto;
use App\Services\Auth\Service\AuthService;
use App\Services\User\Dto\StoreUserDto;
use App\Services\User\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly UserService $userService,
    )
    {
    }

    public function registration(RegistrationAuthRequest $request): JsonResponse
    {
        $data = $request->validated();

        $dto = new StoreUserDto($data);

        $user = $this->userService->store($dto);

        $dto = new StoreTokenAuthDto([
            'user_id' => $user->id,
            'token_name' => $request->device_name ?? $request->userAgent() ?? Str::random(20),
        ]);

        $token = $this->authService->storeToken($dto);

        return response()->json(data: [
            'type' => 'Bearer',
            'token' => $token,
        ])->setStatusCode(ResponseCode::HTTP_CREATED);
    }

    public function login(LoginAuthRequest $request): JsonResponse
    {
        $dto = $request->toDto();

        $token = $this->authService->login($dto);

        return response()->json(data: [
            'type' => 'Bearer',
            'token' => $token,
        ])->setStatusCode(ResponseCode::HTTP_CREATED);

    }

    public function logout(LogoutAuthRequest $request): Response
    {
        $dto = $request->toDto();

        $this->authService->logout($dto);

        return response()->noContent()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);

    }

    public function logoutAll(Request $request): Response
    {
        $dto = new UserIdAuthDto([
            'user_id' => $request->user()->id,
        ]);

        $this->authService->logoutAll($dto);

        return response()->noContent()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }

    public function getSessions(Request $request): JsonResponse
    {
        $dto = new UserIdAuthDto([
            'user_id' => $request->user()->id,
        ]);

        $tokens = $this->authService->getSessions($dto);

        return AuthResource::collection($tokens)->response()->setStatusCode(ResponseCode::HTTP_OK);
    }
}
