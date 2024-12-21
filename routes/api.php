<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::middleware('auth:api')->group(function () {
    // Product routes
    Route::get('/products', [ProductController::class, 'index']);

    // Cart routes
    Route::post('/cart/add', [CartController::class, 'addItem']);
    Route::delete('/cart/remove/{productId}', [CartController::class, 'removeItem']);
    Route::get('/cart', [CartController::class, 'viewCart']);

    // Order routes
    Route::post('/order', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'viewOrders']);
});