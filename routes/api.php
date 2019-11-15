<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    var_dump('api.index');
});

Route::group(['prefix' => 'test', 'namespace' => 'Test'], function() {
    Route::get('index', 'SiteController@index');
});
