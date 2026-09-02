<?php

use App\Common\Constants\FromConst;
use App\Http\Middleware\CheckLogin;
use App\Http\Middleware\LoginLog;
use App\Http\Middleware\OperateLog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('home', 'Test\SiteController@home');

Route::namespace('Test')->prefix('test')->group(function() {
    Route::get('/index', 'SiteController@index');
});

Route::namespace('Site')->group(function() {
    Route::get('/down-list', 'SiteController@getDownList');
});
Route::namespace('Auth')->group(function() {

    Route::middleware(LoginLog::class . ':' . FromConst::FRONTEND)->group(function() {
        Route::post('/login', 'SiteController@login');
        Route::get('/check-login', 'SiteController@isLogin');
        Route::post('/logout', 'SiteController@logout');
    });


    Route::middleware([CheckLogin::class . ':' . FromConst::FRONTEND_NAME, OperateLog::class . ':' . FromConst::FRONTEND])->group(function() {
        Route::post('/auth/self-update', 'SiteController@update');
        Route::get('/auth', 'SiteController@info');
    });
});
