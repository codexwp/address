<?php
use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Cwp\Address\Controllers', 'prefix' => 'address_api'], function () {

    Route::group(['prefix' => 'jp', 'controller' => 'JpAddressController'], function () {

        Route::get('/{zip_code}/location', 'location')->name('location');
        Route::get('/{zip_code}/location_list', 'locationList')->name('location_list');
        Route::get('/prefectures', 'prefectures')->name('prefectures');
        Route::get('/{prefecture_name}/cities', 'cities')->name('cities');
        Route::get('/{city_name}/towns', 'towns')->name('towns');

    });

});

