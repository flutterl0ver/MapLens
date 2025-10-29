<?php

use App\Http\Controllers\LoadLegendController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index');
Route::get('result/{uid}', function($uid) {
    return view('result', ['uid' => $uid]);
});
Route::get('report/{uid}', function($uid) {
    return ReportController::constructReport($uid);
});

Route::post('result', ResultController::class);
Route::post('legend', LoadLegendController::class);
