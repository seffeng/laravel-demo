<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    var_dump('api.index');
});

Route::group(['prefix' => 'test', 'namespace' => 'Test'], function() {
    Route::get('index', 'SiteController@index');
});

Route::group(['namespace' => 'Site'], function() {
    Route::get('/down-list', 'SiteController@getDownList');
});

Route::group(['namespace' => 'Auth'], function() {
    Route::post('/login', 'SiteController@login');
    Route::get('/check-login', 'SiteController@isLogin');
    Route::get('/logout', 'SiteController@logout');
});