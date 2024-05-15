<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//RESTFUL APIs for useer
Route::get('/users/userList', 'UserController@userList');
Route::put('/users/update/{id}', 'UserController@update');
Route::get('/users/detailRecord/{id}', 'UserController@detailRecord');
Route::delete('/users/delete/{id}', 'UserController@delete');
//->middleware(['auth:api']);

//RESTFUL APIs for message
Route::get('/message/inboxList/{id}', 'MessageController@inboxList');
Route::get('/message/sentList/{id}', 'MessageController@sentList');
Route::post('/message/store', 'MessageController@store');
Route::put('/message/update/{id}', 'MessageController@update');
Route::get('/message/detailRecord/{id}', 'MessageController@detailRecord');
Route::delete('/message/delete/{id}', 'MessageController@delete');

//File Upload
Route::post('/file/uploadImage','FileController@uploadImage');

//File Download
Route::get('/file/downloadImage/{fileName}','FileController@downloadImage');

//File Delete
Route::delete('/file/deleteImage/{fileName}','FileController@deleteImage');