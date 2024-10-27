<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CustomerLeadController;
use App\Http\Controllers\CustomerLegderController;
use App\Http\Controllers\EmpController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\admin\VisitorController;
use App\Http\Controllers\delivary\DelivaryController;


use PHPUnit\Event\Code\Test;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin', [AuthController::class, 'login']);

Route::get('/smsbalance', [AuthController::class, 'smsbalance']);


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
    Route::get('admin/stock-transfer/{id}', [StockController::class, 'stocktransfer'])->name('stocktransfer');
    Route::put('admin/stock-transfer/{id}', [StockController::class, 'updatestock'])->name('updatestock');

    Route::get('admin/tarffic-challan', [StockController::class, 'trafficchallan'])->name('trafficchallan');

    Route::get('admin/add-booking', [StockController::class, 'booking'])->name('booking');
    Route::post('admin/add-booking', [StockController::class, 'storebooking'])->name('storebooking');
    Route::get('admin/view-booking', [StockController::class, 'viewbooking'])->name('viewbooking');
    Route::get('admin/print-booking-pdf/{id}', [StockController::class, 'bookinpdf'])->name('bookinpdf');

    Route::get('admin/delivary/add-delivary/{id}', [StockController::class, 'adddelivary'])->name('adddelivary');
    Route::post('admin/delivary/insert-delivary', [StockController::class, 'insertdelivary'])->name('insertdelivary');
    Route::get('admin/delivary/view-delivary', [DelivaryController::class, 'viewdelivary'])->name('viewdelivary');
    Route::get('admin/delivary/delivary_pdf/{id}', [DelivaryController::class, 'delivarypdf'])->name('delivarypdf');
    

    Route::get('admin/data/add-lead', [CustomerLeadController::class, 'addlead'])->name('addlead1');
    Route::post('admin/data/add-lead', [CustomerLeadController::class, 'storeleaddata'])->name('storeleaddata1');
    Route::get('admin/data/view-lead', [CustomerLeadController::class, 'viewleaddata'])->name('viewleaddata1');
    Route::get('admin/data/hot-lead', [CustomerLeadController::class, 'hotleaddata'])->name('hotleaddata');

    Route::get('admin/data/lead-allotment', [VisitorController::class, 'leadallotment'])->name('leadallotment');
    Route::post('admin/data/store-lead-allotment', [VisitorController::class, 'storeleadallotment'])->name('storeleadallotment');

    Route::get('admin/customer/add-ledger', [CustomerLegderController::class, 'addledger'])->name('addledger');
    Route::post('admin/customer/add-ledger', [CustomerLegderController::class, 'storeledger'])->name('storeledger');
    Route::get('admin/customer/view-ledger', [CustomerLegderController::class, 'viewledger'])->name('viewledger');
    Route::get('admin/customer/view-ledger-statement/{id}', [CustomerLegderController::class, 'viewledgerstatement'])->name('viewledgerstatement');
    Route::get('admin/customer/reciept', [CustomerLegderController::class, 'reciept'])->name('reciept');
    Route::post('admin/customer/reciept',[CustomerLegderController::class, 'storerecieptpayment'])->name('storerecieptpayment');
    
    Route::post('admin/customer/getcustomerbalance', [CustomerLegderController::class, 'getcustomerbalance'])->name('getcustomerbalance');

    Route::get('admin/add-employee', [AuthController::class, 'addemployee'])->name('addemployee');
    Route::post('admin/add-employee', [AuthController::class, 'inserempdata'])->name('inserempdata');
    Route::get('admin/view-employee', [AuthController::class, 'viewempdata'])->name('viewempdata');

    Route::get('admin/add-finance', [FinanceController::class, 'addfinancefile'])->name('addfinancefile');
    Route::post('admin/add-finance', [FinanceController::class, 'storefinancefiledetails'])->name('storefinancefiledetails');

    Route::get('admin/view-finance-file', [FinanceController::class, 'viewfinancefile'])->name('viewfinancefile');

    Route::get('admin/view-delivered-file', [FinanceController::class, 'viewdelivaryfile'])->name('viewdelivaryfile');

    Route::get('admin/finance-file-edit/{id}', [FinanceController::class, 'updatefinancefile'])->name('updatefinancefile');
    Route::post('admin/finance/update-file-status', [FinanceController::class, 'updatefilestatus'])->name('updatefilestatus');
    Route::get('admin/finance-file-view/{id}', [FinanceController::class, 'viewrfinancefileremarks'])->name('viewrfinancefileremarks');


    Route::get('admin/visitor/view-visitor', [VisitorController::class, 'vistordata'])->name('vistordata');

    Route::get('admin/delivary/test', [DelivaryController::class, 'test'])->name('test');

    Route::get('admin/random', [VisitorController::class, 'randomrecords'])->name('randomrecords');

    
    
});


Route::get('/employee', [EmpController::class, 'emplogin']);
Route::post('/employee-login', [EmpController::class, 'empauthlogin']);
Route::get('employee/logout', [EmpController::class, 'emplogout'])->name('emplogout');

Route::group(['middleware' => 'empauth'], function () {
    Route::get('employee/dashboard', [EmpController::class, 'dashboard']);

    Route::get('employee/data/add-lead', [EmpController::class, 'addlead'])->name('addlead');
    Route::post('employee/data/add-lead', [EmpController::class, 'storeleaddata'])->name('storeleaddata');
    Route::get('employee/data/view-lead', [EmpController::class, 'viewleaddata'])->name('viewleaddata');

    Route::get('employee/data/update-lead/{id}', [EmpController::class, 'updateleaddata'])->name('updateleaddata');
    Route::put('employee/data/store-update-lead/{id}', [EmpController::class, 'storeupdatedleaddata'])->name('storeupdatedleaddata');

    Route::get('employee/data/calling-lead', [EmpController::class, 'callingfollouplead'])->name('callingfollouplead');
    Route::get('employee/data/visit-followup-lead', [EmpController::class, 'visitfollowuplead'])->name('visitfollowuplead');



    Route::get('employee/data/add-visitor', [EmpController::class, 'visitor'])->name('visitor');
    Route::post('employee/data/add-visitor', [EmpController::class, 'addvisitor'])->name('addvisitor');
    Route::get('employee/data/show-visitor', [EmpController::class, 'viewvisitor'])->name('viewvisitor');

});
