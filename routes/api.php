<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CloudCallingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('cloud-data', [CloudCallingController::class, 'index']);
Route::post('cloud-calling', [CloudCallingController::class, 'cloudcallingapidata']);
