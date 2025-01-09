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



Route::get('/', 'OthersController@index')->name('index');
Route::get('/drills/show/{id}', 'DrillsController@show')->name('show');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/mypage', 'OthersController@mypage')->name('mypage');
    Route::get('/create', 'DrillsController@create')->name('create');
    Route::post('/store', 'DrillsController@store')->name('store');
    Route::get('/drills/{id}', 'DrillsController@edit')->name('edit');
    Route::post('/update/{id}', 'DrillsController@update')->name('update');
});


