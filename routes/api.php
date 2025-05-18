<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;

use App\Http\Controllers\Api\ApiMenuController;
use App\Http\Controllers\Api\ApiOrderController;

Route::post('/update-order-status', [ApiOrderController::class, 'updateOrderStatus']);
Route::get('/payment-status/{orderId}', [ApiOrderController::class, 'updatePaymentStatus']);

Route::post('/login', [ApiAuthController::class, 'getLogin']);
Route::post('/getUser', [ApiAuthController::class, 'getUserData']);
Route::post('/getMitraData', [ApiAuthController::class, 'getMitraData']);
Route::post('/getMenu', [ApiMenuController::class, 'getMenu']);
Route::post('/sendOrder', [ApiOrderController::class, 'sendOrder']);
