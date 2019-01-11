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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'ShowController@index');
Route::get('/ajax_table', 'ShowController@user_passwd');
Route::get('/password_list_year', 'ShowController@password_list_year');
Route::get('/user_list_year', 'ShowController@user_list_year');
Route::get('/user_pass_list_year', 'ShowController@user_pass_list_year');
Route::get('/ajax_daily_attack', 'ShowController@ajax_daily_attack');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
