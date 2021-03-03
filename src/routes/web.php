<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return 'Docker works! State project';
});

//State routes
Route::group(['prefix' => 'state'], function () {
    Route::post('/', 'StateController@create');
    Route::get('/', 'StateController@read')->where('stateId', '[0-9]+');
    Route::put('/{stateId}', 'StateController@update')->where('stateId', '[0-9]+');
    Route::delete('/{stateId}', 'StateController@delete')->where('stateId', '[0-9]+');
});

//City routes
Route::group(['prefix' => 'city'], function () {
    Route::post('/', 'CityController@create');
    Route::get('/', 'CityController@read')->where('cityId', '[0-9]+');
    Route::put('/{cityId}', 'CityController@update')->where('cityId', '[0-9]+');
    Route::delete('/{cityId}', 'CityController@delete')->where('cityId', '[0-9]+');
});
