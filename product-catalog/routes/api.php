<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// To login and logout or get authentication token, authentication is required
Route::post('/login', [AuthController::class, "login"]);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, "logout"]);

// To get the product information, Authentication is required
Route::middleware('auth:sanctum')->group(function () {
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{product}', [ProductController::class, 'update']);
    Route::delete('products/{product}', [ProductController::class, 'destroy']);
});

// To get the product information, No authentication is required
Route::get('products', [ProductController::class, 'index'])->middleware('api');
Route::middleware('api')->get('products/{product}', [ProductController::class, 'show']);