<?php
use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Cwp\Address\Controllers', 'prefix' => 'cwp/address'], function () {

    Route::group(['prefix' => 'japan', 'controller' => 'JpAddressController'], function () {

        Route::get('/', 'index')->name('index');

    });

});

