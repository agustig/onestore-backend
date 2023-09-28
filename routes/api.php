<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentCallbackController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/profile', [ProfileController::class, 'show'])
    ->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::post('image/upload', [UploadController::class, 'uploadImage'])
    ->middleware('auth:sanctum');
Route::post('image/multiple-upload', [UploadController::class, 'uploadMultipleImages'])
    ->middleware('auth:sanctum');

Route::post('order', [OrderController::class, 'order'])
    ->middleware('auth:sanctum');

Route::post('midtrans-notification-handling', [PaymentCallbackController::class, 'callback']);

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('banners', BannerController::class);
