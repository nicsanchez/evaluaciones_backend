<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
    Capa de Rutas: En esta capa se definen las rutas API las cuales pueden ser consumidas.
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar

*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'App\Http\Controllers\AuthenticateController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('user','App\Http\Controllers\AuthenticateController@getAuthenticatedUser');
    Route::post('logout','App\Http\Controllers\AuthenticateController@logout');

    Route::group(['prefix' => 'users'],function (){
        Route::post('getUsers','App\Http\Controllers\Users\UsersController@getUsers');
        Route::post('createUser','App\Http\Controllers\Users\UsersController@createUser');
        Route::post('deleteUser','App\Http\Controllers\Users\UsersController@deleteUser');
        Route::post('updateUser','App\Http\Controllers\Users\UsersController@updateUser');
        Route::post('getUser','App\Http\Controllers\Users\UsersController@getUser');
    });

    Route::group(['prefix' => 'evaluations'],function (){
        Route::post('saveAttachments','App\Http\Controllers\Evaluations\EvaluationsController@saveAttachments');
        Route::post('getEvaluations','App\Http\Controllers\Evaluations\EvaluationsController@getEvaluations');
        Route::post('downloadFileByFilename','App\Http\Controllers\Evaluations\EvaluationsController@downloadFileByFilename');
        Route::post('downloadFilesByBulkFile','App\Http\Controllers\Evaluations\EvaluationsController@downloadFilesByBulkFile');
    });

});
