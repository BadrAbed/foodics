<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\V1\OrderController;

Route::post('orders', [OrderController::class, 'store']);
