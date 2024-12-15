<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::get('products', [ProductController::class, 'getAllProduct']);
Route::get('product/{id}', [ProductController::class, 'getProduct']);






Route::group(['middleware'=>'api'],function(){
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('getUser',[AuthController::class, 'getUser']);
    Route::put('updateProduct/{id}', [ProductController::class, 'updateProduct']);
    Route::post('createOrder', [OrderController::class, 'createOrder']);
    Route::post('purchaseOrder', [OrderController::class, 'purchaseOrder']);
    Route::post('createProduct', [ProductController::class, 'createProduct']);
    Route::delete('destroyProduct', [ProductController::class, 'destroyProduct/{id}']);

});


