<?php

use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index');
Route::get('result/{uid}', function($uid) {
    return view('result', ['uid' => $uid]);
});

Route::post('result', ResultController::class);
