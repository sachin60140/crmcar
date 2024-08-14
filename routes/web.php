<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CustomerLeadController;
use App\Http\Controllers\CustomerLegderController;
use App\Http\Controllers\EmpController;
use App\Http\Controllers\FinanceController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin', [AuthController::class, 'login']);


Route::get('pass', [AuthController::class, 'pass']);

Route::post('admin-login', [AuthController::class, 'authlogin']);

Route::get('admin/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/dashboard', [AuthController::class, 'dashboard']);
    Route::get('admin/add-branch', [AuthController::class, 'branch'])->name('branch');
    Route::post('admin/add-branch', [AuthController::class, 'addbranch'])->name('addbranch');
    Route::get('admin/view-branch', [AuthController::class, 'viewbranch'])->name('viewbranch');;

    Route::get('admin/add-stock', [StockController::class, 'addstock'])->name('addstock');
    Route::post('admin/add-stock', [StockController::class, 'insertstock'])->name('insertstock');
    Route::get('admin/view-stock', [StockController::class, 'viewstock'])->name('viewstock');

    Route::get('admin/tarffic-challan', [StockController::class, 'trafficchallan'])->name('trafficchallan');

    Route::get('admin/add-booking', [StockController::class, 'booking'])->name('booking');
    Route::post('admin/add-booking', [StockController::class, 'storebooking'])->name('storebooking');
    Route::get('admin/view-booking', [StockController::class, 'viewbooking'])->name('viewbooking');
    Route::get('admin/print-booking-pdf/{id}', [StockController::class, 'bookinpdf'])->name('bookinpdf');
    

    Route::get('admin/data/add-lead', [CustomerLeadController::class, 'addlead'])->name('addlead1');
    Route::post('admin/data/add-lead', [CustomerLeadController::class, 'storeleaddata'])->name('storeleaddata1');
    Route::get('admin/data/view-lead', [CustomerLeadController::class, 'viewleaddata'])->name('viewleaddata1');

    Route::get('admin/customer/add-ledger', [CustomerLegderController::class, 'addledger'])->name('addledger');
    Route::post('admin/customer/add-ledger', [CustomerLegderController::class, 'storeledger'])->name('storeledger');
    Route::get('admin/customer/view-ledger', [CustomerLegderController::class, 'viewledger'])->name('viewledger');
    Route::get('admin/customer/view-ledger-statement/{id}', [CustomerLegderController::class, 'viewledgerstatement'])->name('viewledgerstatement');

    Route::get('admin/add-employee', [AuthController::class, 'addemployee'])->name('addemployee');
    Route::post('admin/add-employee', [AuthController::class, 'inserempdata'])->name('inserempdata');
    Route::get('admin/view-employee', [AuthController::class, 'viewempdata'])->name('viewempdata');

    Route::get('admin/add-finance', [FinanceController::class, 'addfinancefile'])->name('addfinancefile');
});



Route::get('/employee', [EmpController::class, 'emplogin']);
Route::post('/employee-login', [EmpController::class, 'empauthlogin']);
Route::get('employee/logout', [EmpController::class, 'emplogout'])->name('emplogout');

Route::group(['middleware' => 'empauth'], function () {
    Route::get('employee/dashboard', [EmpController::class, 'dashboard']);

    Route::get('employee/data/add-lead', [EmpController::class, 'addlead'])->name('addlead');
    Route::post('employee/data/add-lead', [EmpController::class, 'storeleaddata'])->name('storeleaddata');
    Route::get('employee/data/view-lead', [EmpController::class, 'viewleaddata'])->name('viewleaddata');
});
