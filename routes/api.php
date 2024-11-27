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
    // Health professional services
    Route::get('/health-professionals', [HealthProfessionalController::class, 'index']);
    Route::post('/health-professionals', [HealthProfessionalController::class, 'store']);
    Route::get('/health-professionals/{specialty}', [HealthProfessionalController::class, 'findProfessionalBySpecialty']);

    // Availability services
    Route::post('/availabilities', [AvailabilityController::class, 'store']);
    Route::get('/availabilities', [AvailabilityController::class, 'index']);

    // Appointment services
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::post('/appointments/{appointmentId}/cancel', [AppointmentController::class, 'cancelAppointment']);

    Route::post('/chat/message', [ChatController::class, 'sendMessage']);

    Route::middleware(['professional'])->group(function () {
        Route::get('/professional/appointments', [ProfessionalAppointmentController::class, 'index']);
    });
});

// Chat service
Route::post('/messages', [ChatController::class, 'getMessages']);

// Public services
Route::get('/specialties', [SpecialtyController::class, 'index']);
Route::get('/health-professionals', [HealthProfessionalController::class, 'index']);

Route::post('/find-availaibility-filter', [AvailabilityController::class, 'getByProfessionDateHour']);
