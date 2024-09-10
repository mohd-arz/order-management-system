<?php

use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\OrdersController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Middleware\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([Auth::class])->group(function(){
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');
    Route::prefix('orders')->controller(OrdersController::class)->group(function(){
        Route::get('/','index')->name('orders.index');
        Route::get('/getOrders','getOrders')->name('orders.getOrders');
        Route::get('/{order}/edit','edit')->name('orders.edit');
        Route::put('/{order}/update','update')->name('orders.update');
    });
});


Route::get('/login',[LoginController::class,'index'])->name('login.view');
Route::post('/login',[LoginController::class,'login'])->name('login');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');