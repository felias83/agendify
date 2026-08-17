<?php

use App\Http\Controllers\Api\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttachmentController; 



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::post('/appointments/{appointment}/attachment', [AttachmentController::class, 'upload']);
});