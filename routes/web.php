<?php

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

Auth::routes();


Route::prefix('string')->group(function () {
    Route::get('toArray', 'StringController@toArray');
});

Route::prefix('array')->group(function () {
    Route::get('toString', 'ArrayController@toString');
});