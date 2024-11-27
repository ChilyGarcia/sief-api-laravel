<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AvailabilityController;
use App\Http\Controllers\Api\HealthProfessionalController;
use App\Http\Controllers\Api\Professional\ProfessionalAppointmentController;
use App\Http\Controllers\Api\SpecialtyController;
use App\Http\Controllers\ChatController;

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth',
    ],
    function ($router) {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])
            ->middleware('auth:api')
            ->name('logout');
        Route::post('/refresh', [AuthController::class, 'refresh'])
            ->middleware('auth:api')
            ->name('refresh');
        Route::post('/me', [AuthController::class, 'me'])
            ->middleware('auth:api')
            ->name('me');
    },
);

Route::group(['middleware' => 'auth:api'], function () {



    Route::post('/chat/message', [ChatController::class, 'sendMessage']);
});

// Chat service
Route::post('/messages', [ChatController::class, 'getMessages']);
