<?php
use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Cwp\Address\Controllers', 'prefix' => 'address_api'], function () {

    Route::group(['prefix' => 'jp', 'controller' => 'JpAddressController'], function () {

        Route::get('/{pref}/{city}/{town}/code', 'code')->name('code');
        Route::get('/{code}/location', 'location')->name('location');
        Route::get('/{code}/location_list', 'locationList')->name('location_list');
        Route::get('/prefectures', 'prefectures')->name('prefectures');
        Route::get('/{prefecture_name}/cities', 'cities')->name('cities');
        Route::get('/{prefecture_name}/{city_name}/towns', 'towns')->name('towns');

    });

    Route::group(['prefix' => 'bd', 'controller' => 'BdAddressController'], function () {

        Route::get('/divisions', 'divisions')->name('divisions');
        Route::get('/{division_name}/districts', 'districts')->name('districts');
        Route::get('/{division_name}/{district_name}/upazilas', 'upazilas')->name('upazilas');

    });

});

