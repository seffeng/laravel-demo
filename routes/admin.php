<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    var_dump('admin.index');
    //return view('home');
});

Route::group(['namespace' => 'Site'], function() {
    Route::get('/down-list', 'SiteController@getDownList');
});

Route::group(['namespace' => 'Auth'], function() {
    Route::post('/login', 'SiteController@login');
    Route::get('/check-login', 'SiteController@isLogin');
    Route::get('/logout', 'SiteController@logout');
});

Route::group(['middleware' => ['checkLogin:admin']], function() {
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
        Route::get('/index', 'SiteController@index');
        Route::post('/index', 'SiteController@create');
        Route::put('/index', 'SiteController@update');
        Route::delete('/index', 'SiteController@delete');
    });
});
