<?php

use App\Common\Constants\FromConst;
use App\Http\Middleware\CheckLogin;
use App\Http\Middleware\LoginLog;
use App\Http\Middleware\OperateLog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::namespace('Site')->group(function() {
    Route::get('down-list', 'SiteController@getDownList');
});

Route::namespace('Auth')->middleware(LoginLog::class . ':' . FromConst::BACKEND)->group(function() {
    Route::post('login', 'SiteController@login');
    Route::get('check-login', 'SiteController@isLogin');
    Route::post('logout', 'SiteController@logout');
});

Route::middleware([CheckLogin::class . ':' . FromConst::BACKEND_NAME, OperateLog::class . ':' . FromConst::BACKEND])->group(function() {

    Route::namespace('Log')->group(function() {
        Route::get('operate-log', 'SiteController@operateLog');
        Route::get('admin/login-log', 'SiteController@adminLoginLog');
        Route::get('user/login-log', 'SiteController@userLoginLog');
    });

    Route::namespace('Auth')->group(function() {
        Route::post('auth/self-update', 'SiteController@update');
        Route::get('auth', 'SiteController@info');
    });

    Route::namespace('Admin')->prefix('admin')->group(function() {
        Route::get('', 'SiteController@index');
        Route::post('create', 'SiteController@create');
        Route::post('on', 'SiteController@on');
        Route::post('off', 'SiteController@off');
        Route::post('update', 'SiteController@update');
        Route::post('delete', 'SiteController@delete');
    });

    Route::namespace('User')->prefix('user')->group(function() {
        Route::get('', 'SiteController@index');
        Route::post('create', 'SiteController@create');
        Route::post('on', 'SiteController@on');
        Route::post('off', 'SiteController@off');
        Route::post('update', 'SiteController@update');
        Route::post('delete', 'SiteController@delete');
    });
});
