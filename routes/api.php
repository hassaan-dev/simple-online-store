<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Public API routes
Route::get('/products', [ProductController::class, 'apiIndex']);

// Protected API routes
Route::middleware('auth')->group(function () {
    Route::post('/checkout', [OrderController::class, 'checkout']);
});

Route::get('ping', function ()
{
    return 'pong';
});
