<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransWebhookController; // Add this import
use App\Http\Controllers\RekomendasiController; // Corrected namespace

/*
|---------------------------------------------------------------------------
| API Routes
|---------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('midtrans-webhook', [MidtransWebhookController::class, 'handleNotification']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Corrected Route for /laundry/nearby
Route::get('/laundry/nearby', [RekomendasiController::class, 'rekomendasiLaundry']);
