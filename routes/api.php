<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\User\UserController;
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

    Route::get('/current', [UserController::class, 'current'])
        ->name('api.v1.current')
        ->middleware([
            'auth:sanctum',
        ]);
});
