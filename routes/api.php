<?php

use App\Common\Constants\FromConst;
use App\Http\Middleware\CheckLogin;
use App\Http\Middleware\LoginLog;
use App\Http\Middleware\OperateLog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    exit('This api.home. Now is ' . date('Y-m-d H:i:s'));
});

Route::namespace('Test')->prefix('test')->group(function() {
    Route::get('index', 'SiteController@index');
});

Route::namespace('Site')->group(function() {
    Route::get('/down-list', 'SiteController@getDownList');
});

Route::namespace('Auth')->group(function() {
    Route::middleware(LoginLog::class . ':' . FromConst::API)->group(function() {
        Route::post('/login', 'SiteController@login');
        Route::get('/check-login', 'SiteController@isLogin');
        Route::post('/logout', 'SiteController@logout');
    });

    Route::middleware([CheckLogin::class . ':' . FromConst::API_NAME, OperateLog::class . ':' . FromConst::API])->group(function() {
        Route::post('/auth/self-update', 'SiteController@update');
        Route::get('/auth', 'SiteController@info');
    });
});
