<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Chat\ChatController;
use App\Http\Controllers\Api\v1\Chat\ChatParticipantController;
use App\Http\Controllers\Api\v1\Chat\MessageController;
use App\Http\Controllers\Api\v1\Friendship\FriendshipController;
use App\Http\Controllers\Api\v1\Recommendation\RecommendationController;
use App\Http\Controllers\Api\v1\User\UserController;
use App\Models\Chat\ChatParticipant;
use App\Services\RecommendationService\Dto\RecommendationDto;
use App\Services\RecommendationService\Service\RecommendationService;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    Route::post('/register', [AuthController::class, 'registration'])
        ->name('api.v1.register');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('api.v1.login');

    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::post('/logout-all', [AuthController::class, 'logoutAll'])
            ->name('api.v1.logout-all');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('api.v1.logout');

        route::get('/sessions', [AuthController::class, 'getSessions'])
            ->name('api.v1.sessions');
    });

    Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [UserController::class, 'index'])
            ->name('api.v1.users.index');

        Route::get('/{user}', [UserController::class, 'show'])
            ->name('api.v1.users.show');

        Route::delete('/{user}', [UserController::class, 'destroy'])
            ->name('api.v1.users.destroy');

        Route::patch('/{user}', [UserController::class, 'update'])
            ->name('api.v1.users.update');
    });

    Route::group(['prefix' => 'friends', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [FriendshipController::class, 'index'])
            ->name('api.v1.friends.index');

        Route::get('/{friendship}', [FriendshipController::class, 'show'])
            ->name('api.v1.friends.show');

        Route::delete('/{friendship}', [FriendshipController::class, 'destroy'])
            ->name('api.v1.friends.destroy');

        Route::patch('/{friendship}', [FriendshipController::class, 'update'])
            ->name('api.v1.friends.update');

        Route::post('/', [FriendshipController::class, 'store'])
            ->name('api.v1.friends.store');
    });

    Route::group(['prefix' => 'chats', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [ChatController::class, 'index'])
            ->name('api.v1.chats.index');

        Route::get('/{chat}', [ChatController::class, 'show'])
            ->name('api.v1.chats.show');

        Route::delete('/{chat}', [ChatController::class, 'destroy'])
            ->name('api.v1.chats.destroy');

        Route::patch('/{chat}', [ChatController::class, 'update'])
            ->name('api.v1.chats.update');

        Route::post('/', [ChatController::class, 'store'])
            ->name('api.v1.chats.store');

        Route::group(['prefix' => '{chat}/participants', 'middleware' => 'auth:sanctum'], function () {
            Route::post('/', [ChatParticipantController::class, 'store'])
                ->name('api.v1.chats.participants.store');

            Route::delete('/{chat_participant_id}', [ChatParticipantController::class, 'destroy'])
                ->name('api.v1.chats.participants.destroy');

            Route::patch('/{chat_participant_id}', [ChatParticipantController::class, 'update'])
                ->name('api.v1.chats.participants.update');
        });

        Route::group(['prefix' => '{chat}/messages', 'middleware' => 'auth:sanctum'], function () {
            Route::post('/', [MessageController::class, 'store'])
                ->name('api.v1.chat.messages.store');

            Route::delete('/{message_id}', [MessageController::class, 'destroy'])
                ->name('api.v1.chat.messages.destroy');

            Route::patch('/{message_id}', [MessageController::class, 'update'])
                ->name('api.v1.chat.messages.update');

            Route::get('/{message_id}', [MessageController::class, 'show'])
                ->name('api.v1.chat.messages.show');

            Route::get('/', [MessageController::class, 'index'])
                ->name('api.v1.chat.messages.index');
        });
    });

    Route::get('/recommendations', [RecommendationController::class, 'getSuggests'])
        ->middleware('auth:sanctum')
        ->name('api.v1.recommendations.get');

    Route::get('/current', [UserController::class, 'current'])
        ->name('api.v1.current')
        ->middleware([
            'auth:sanctum',
        ]);
});
