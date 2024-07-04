<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin',[AuthController::class, 'login']);

Route::get('pass',[AuthController::class, 'pass']);

Route::post('admin-login',[AuthController::class, 'authlogin']);

Route::get('admin/logout',[AuthController::class, 'logout']);

Route::group(['middleware'=>'admin'],function()
{
    Route::get('admin/dashboard',[AuthController::class, 'dashboard']);
    Route::get('admin/add-clients',[AuthController::class, 'lead'])->name('leads');
    Route::post('admin/add-clients',[AuthController::class, 'client'])->name('addlead');

 
});
