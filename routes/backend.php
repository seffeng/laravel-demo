<?php

use App\Common\Constants\FromConst;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('home');
});

Route::group(['namespace' => 'Site'], function() {
    Route::get('down-list', 'SiteController@getDownList');
});

Route::group(['namespace' => 'Auth', 'middleware' => ['log.login:' . FromConst::BACKEND]], function() {
    Route::post('login', 'SiteController@login');
    Route::get('check-login', 'SiteController@isLogin');
    Route::post('logout', 'SiteController@logout');
});

Route::group(['middleware' => ['check.login:backend', 'log.operate:' . FromConst::BACKEND]], function() {

    Route::group(['namespace' => 'Log'], function() {
        Route::get('operate-log', 'SiteController@operateLog');
        Route::get('admin/login-log', 'SiteController@adminLoginLog');
        Route::get('user/login-log', 'SiteController@userLoginLog');
    });

    Route::group(['namespace' => 'Auth'], function() {
        Route::post('auth/self-update', 'SiteController@update');
        Route::get('auth', 'SiteController@info');
    });

    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
        Route::get('', 'SiteController@index');
        Route::post('create', 'SiteController@create');
        Route::post('on', 'SiteController@on');
        Route::post('off', 'SiteController@off');
        Route::post('update', 'SiteController@update');
        Route::post('delete', 'SiteController@delete');
    });

    Route::group(['namespace' => 'User', 'prefix' => 'user'], function() {
        Route::get('', 'SiteController@index');
    });
});
