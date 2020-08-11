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

Route::get('/', function () {
    return view('welcome');
});
Route::resource('customers','CustomerController');
Route::get('customers/{id}/edit/','CustomerController@edit');
Route::get('get-city-list','CustomerController@getCityList');
Route::post('verifydata', 'CustomerController@formValidation');
