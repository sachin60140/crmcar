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
use App\Http\Controllers\API\CloudCallingController;
use App\Http\Controllers\API\WhatsAppApiController;
use App\Http\Controllers\dto\DtoController;
use App\Http\Controllers\workshop\CarInspectionController;
use App\Http\Controllers\UploadStockPaperController;
use App\Http\Controllers\WaterMarkController;
use App\Http\Controllers\admin\DashboardDataController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\chart\ChartController;



use PHPUnit\Event\Code\Test;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/watermark', [WaterMarkController::class, 'watermark']);
Route::get('/qr-code', [WaterMarkController::class, 'qrcode']);

Route::get('/test-api', [WhatsAppApiController::class, 'testapi']);

Route::get('/admin', [AuthController::class, 'login'])->name('login');

Route::get('/smsbalance', [AuthController::class, 'smsbalance']);


Route::get('pass', [AuthController::class, 'pass']);

Route::post('admin-login', [AuthController::class, 'authlogin'])->name('admin-login');

Route::get('admin/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['admin', 'single.session']], function () {
    Route::get('admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/dashboard/live-kpis', [AuthController::class, 'dashboard'])->name('dashboard.live.kpis');
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change.password');
    Route::put('/change-password', [AuthController::class, 'updatePassword'])->name('change.password.update');
    Route::get('admin/add-branch', [AuthController::class, 'branch'])->name('branch');
    Route::post('admin/add-branch', [AuthController::class, 'addbranch'])->name('addbranch');
    Route::get('admin/view-branch', [AuthController::class, 'viewbranch'])->name('viewbranch');;

    Route::get('admin/add-stock', [StockController::class, 'addstock'])->name('addstock');
    Route::post('admin/add-stock', [StockController::class, 'insertstock'])->name('insertstock');
    Route::get('admin/view-stock', [StockController::class, 'viewstock'])->name('viewstock');
    Route::get('admin/stock-transfer/{id}', [StockController::class, 'stocktransfer'])->name('stocktransfer');
    Route::put('admin/stock-transfer/{id}', [StockController::class, 'updatestock'])->name('updatestock');
     
    /* CPaper Upload Start Here */
    Route::get('admin/stock/add-stock-paper', [UploadStockPaperController::class,'addstockpaper' ])->name('addstockpaper');
    Route::post('admin/stock/store-stock-paper', [UploadStockPaperController::class,'storestockpaper' ])->name('storestockpaper');
    Route::get('admin/stock/view-stock-paper', [UploadStockPaperController::class,'viewstockpaper' ])->name('viewstockpaper');
    Route::get('admin/stock/download/{id}', [UploadStockPaperController::class,'downloadfile' ])->name('files.download');

    Route::get('admin/stock/stock-paper-details', [UploadStockPaperController::class,'stockpaperdetails' ])->name('stockpaperdetails');
    /* Paper Upload end Here */
     

    Route::get('admin/tarffic-challan', [StockController::class, 'trafficchallan'])->name('trafficchallan');

    Route::get('admin/add-booking', [StockController::class, 'booking'])->name('booking');
    Route::post('admin/add-booking', [StockController::class, 'storebooking'])->name('storebooking');
    Route::get('admin/view-booking', [StockController::class, 'viewbooking'])->name('viewbooking');
    Route::get('admin/print-booking-pdf/{id}', [StockController::class, 'bookinpdf'])->name('bookinpdf');
    Route::get('/admin/export-bookings', [StockController::class, 'exportBookings']);
    Route::post('/admin/insert-cancel-booking', [StockController::class, 'insertCancelBooking'])->name('insertCancelBooking');

    
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
    Route::get('admin/edit-employee/{id?}', [AuthController::class, 'editempdata'])->name('editempdata');
    Route::put('admin/edit-employee/{user}', [AuthController::class, 'updateuserPassword'])->name('updateuserPassword');

    Route::get('admin/add-finance', [FinanceController::class, 'addfinancefile'])->name('addfinancefile');
    Route::post('admin/add-finance', [FinanceController::class, 'storefinancefiledetails'])->name('storefinancefiledetails');

    Route::get('admin/view-finance-file', [FinanceController::class, 'viewfinancefile'])->name('viewfinancefile');

    Route::get('admin/view-delivered-file', [FinanceController::class, 'viewdelivaryfile'])->name('viewdelivaryfile');
    Route::get('admin/ready-for-delevery', [FinanceController::class, 'viewreadyfordelivaryfile'])->name('viewreadyfordelivaryfile');
    Route::get('admin/view-decline-file', [FinanceController::class, 'viewdeclinefile'])->name('viewdeclinefile');

    Route::get('admin/finance-file-edit/{id}', [FinanceController::class, 'updatefinancefile'])->name('updatefinancefile');
    Route::post('admin/finance/update-file-status', [FinanceController::class, 'updatefilestatus'])->name('updatefilestatus');
    Route::get('admin/finance-file-view/{id}', [FinanceController::class, 'viewrfinancefileremarks'])->name('viewrfinancefileremarks');


    Route::get('admin/visitor/view-visitor', [VisitorController::class, 'vistordata'])->name('vistordata');

    Route::get('admin/delivary/test', [DelivaryController::class, 'test'])->name('test');

    Route::get('admin/random', [VisitorController::class, 'randomrecords'])->name('randomrecords');

    /* Cloud Calling Data */
    Route::get('admin/cloud-calling/cloud-calling-data', [CloudCallingController::class, 'showcloudacalldata'])->name('showcloudacalldata');
    Route::get('admin/just-dail/just-dail-data', [CloudCallingController::class, 'showjustdaildata'])->name('showjustdaildata');
    //Route::get('admin/Cloud-Call/Qkonnect-Call-Data', [CloudCallingController::class, 'showqkonnectdata'])->name('qkonnectcalldata');
   Route::any('admin/cloud-calling/qkonnect-call-data', [CloudCallingController::class, 'showqkonnectdata'])->name('qkonnectcalldata');

    /* DTO File  */
    Route::get('admin/dto/add-file', [DtoController::class, 'index'])->name('adddtofile');
    Route::post('admin/dto/store-dto-file', [DtoController::class, 'adddtofile'])->name('storetofile');
    Route::get('admin/dto/view-dto-file', [DtoController::class, 'viewdtofile'])->name('viewdtofile');
    Route::get('admin/dto/edit-dto-file/{id}', [DtoController::class, 'editdtofile'])->name('editdtofile');
    Route::put('admin/dto/update-dto-file/{id}', [DtoController::class, 'updatedtofile'])->name('updatedtofile');
    Route::get('admin/dto/view-online-dto-file', [DtoController::class, 'viewonlinedtofile'])->name('viewonlinedtofile');
    Route::get('admin/dto/get-history/{id}', [DtoController::class, 'getHistory']);
    Route::post('admin/dto/bulk-update', [DtoController::class, 'bulkUpdate']);
    Route::post('admin/dto/get-dto-location', [DtoController::class, 'getdtolocation'])->name('getdtolocation');
    /* Inspection  */
    Route::get('admin/workshop/inspection', [CarInspectionController::class, 'index'])->name('inspection');
    Route::post('admin/workshop/store-inspection', [CarInspectionController::class, 'storeinspection'])->name('storeinspection');
    Route::get('admin/workshop/view-inspection', [CarInspectionController::class, 'viewinspection'])->name('viewinspection');
    /* End Inspection  */
    
    /* Dashboard Ajax Data*/
    Route::get('/dashboard-stats', [DashboardDataController::class, 'fetchData'])->name('dashboard_data');
    /* End Dashboard Ajax Data*/

    /* Add Vendor Section */
    Route::get('admin/add-vendor', [VendorController::class, 'index'])->name('addvendor');
    Route::post('admin/store-vendor', [VendorController::class, 'store'])->name('storevendor');
    /* End Vendor Section */

    /* Chart Section Section */
    
    Route::get('/chart-data', [ChartController::class, 'chartData'])->name('chart.data');
    Route::get('/get-online-chart-data', [ChartController::class, 'getOnlineReportData'])->name('get.online.chart.data');


    /* End Chart Section */
    
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

    /* Cloud Call Data View */ 
    Route::get('employee/Cloud-Call/Cloud-Call-Data', [EmpController::class, 'showcloudacalldata'])->name('viewcloudcalldata');

});


