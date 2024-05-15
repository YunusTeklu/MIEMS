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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Pages for User
Route::get('/users', 'UserController@index')->middleware('auth');
Route::get('/users/edit', 'UserController@edit')->middleware('auth');
Route::get('/users/detail/{id}', 'UserController@detail')->middleware('auth');

//Pages for Message
Route::get('/message/inbox', 'MessageController@inbox')->middleware('auth');
Route::get('/message/sent', 'MessageController@sent')->middleware('auth');
Route::get('/message/compose', 'MessageController@compose')->middleware('auth');
Route::get('/message/edit', 'MessageController@edit')->middleware('auth');
Route::get('/message/detail/{id}', 'MessageController@detail')->middleware('auth');
