<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CustomerLeadController;
use App\Http\Controllers\CustomerLegderController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin',[AuthController::class, 'login']);

Route::get('pass',[AuthController::class, 'pass']);

Route::post('admin-login',[AuthController::class, 'authlogin']);

Route::get('admin/logout',[AuthController::class, 'logout'])->name('logout');

Route::group(['middleware'=>'admin'],function()
{
    Route::get('admin/dashboard',[AuthController::class, 'dashboard']);
    Route::get('admin/add-branch',[AuthController::class, 'branch'])->name('branch');
    Route::post('admin/add-branch',[AuthController::class, 'addbranch'])->name('addbranch');
    Route::get('admin/view-branch',[AuthController::class, 'viewbranch'])->name('viewbranch');;

    Route::get('admin/add-stock',[StockController::class, 'addstock'])->name('addstock');
    Route::post('admin/add-stock',[StockController::class, 'insertstock'])->name('insertstock');
    Route::get('admin/view-stock',[StockController::class, 'viewstock'])->name('viewstock');

    Route::get('admin/tarffic-challan',[StockController::class, 'trafficchallan'])->name('trafficchallan');
    
    Route::get('admin/add-booking',[StockController::class, 'booking'])->name('booking');
    Route::post('admin/add-booking',[StockController::class, 'storebooking'])->name('storebooking');

    Route::get('admin/data/add-lead',[CustomerLeadController::class, 'addlead'])->name('addlead');
    Route::post('admin/data/add-lead',[CustomerLeadController::class, 'storeleaddata'])->name('storeleaddata');
    Route::get('admin/data/view-lead',[CustomerLeadController::class, 'viewleaddata'])->name('viewleaddata');
 
    Route::get('admin/customer/add-ledger',[CustomerLegderController::class, 'addledger'])->name('addledger');
    Route::post('admin/customer/add-ledger',[CustomerLegderController::class, 'storeledger'])->name('storeledger');
    Route::get('admin/customer/view-ledger',[CustomerLegderController::class, 'viewledger'])->name('viewledger');
    Route::get('admin/customer/view-ledger-statement/{id}',[CustomerLegderController::class, 'viewledgerstatement'])->name('viewledgerstatement');
});
