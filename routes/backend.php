<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('home');
});

Route::group(['namespace' => 'Site'], function() {
    Route::get('/down-list', 'SiteController@getDownList');
});

Route::group(['namespace' => 'Auth'], function() {
    Route::post('/login', 'SiteController@login');
    Route::get('/check-login', 'SiteController@isLogin');
    Route::post('/logout', 'SiteController@logout');
});

Route::group(['namespace' => 'Auth', 'middleware' => ['checkLogin:backend']], function() {
    Route::post('/auth/self-update', 'SiteController@update');
    Route::get('/auth', 'SiteController@info');
});

Route::group(['middleware' => ['checkLogin:backend']], function() {
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
        Route::get('', 'SiteController@index');
        Route::post('create', 'SiteController@create');
        Route::post('update', 'SiteController@update');
        Route::post('delete', 'SiteController@delete');
    });
});
