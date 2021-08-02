<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\AuthController;
// Public Routes
// Route::resource('products', ProductController::class);
// Register
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::get('/products',[ProductController::class,'index']);
Route::get('/products/{id}',[ProductController::class,'show']);
Route::get('/products/search/{name}',[ProductController::class,'search']);


// Protected Routes
Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::post('/products',[ProductController::class,'store']);
    Route::put('/products/{id}',[ProductController::class,'update']);
    Route::delete('/products/{id}',[ProductController::class,'destroy']);
    // Logout
    Route::post('/logout',[AuthController::class,'logout']);
    
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
