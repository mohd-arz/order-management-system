<?php

use App\Http\Controllers\Api\Auth\V1\LoginController;
use App\Http\Controllers\Api\Auth\V1\UserController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function(){
    Route::controller(LoginController::class)->group(function(){
        Route::post('/register','register');
        Route::post('/login','login');
        Route::post('/forgot_password','forgot_password');
    });
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('logout', [LoginController::class, 'logout']);
        Route::controller(UserController::class)->group(function(){
            Route::get('/products','getProducts');
            Route::post('/create_orders','createOrders');
            Route::get('/get_orders','getOrders');
        });
    });

});
