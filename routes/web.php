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

Route::get('/', ['as' => 'tool', 'uses' => 'ToolController@lists']);

Route::prefix('tool')->group(function () {
    Route::any('string_to_array', 'ToolController@stringToArray');
    Route::any('array_to_string', 'ToolController@arrayToString');
    Route::any('array_compare', 'ToolController@arrayCompare');
    Route::any('array_merge', 'ToolController@arrayMerge');
    Route::any('array_unique', 'ToolController@arrayUnique');
});

