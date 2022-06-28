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

    Route::group(['middleware' => ['permissions.verify']], function() {
        Route::group(['prefix' => 'users'],function (){
            Route::post('getUsers','App\Http\Controllers\Users\UsersController@getUsers');
            Route::post('createUser','App\Http\Controllers\Users\UsersController@createUser');
            Route::post('deleteUser','App\Http\Controllers\Users\UsersController@deleteUser');
            Route::post('updateUser','App\Http\Controllers\Users\UsersController@updateUser');
        });
        Route::group(['prefix' => 'evaluations'],function (){
            Route::post('saveAttachments','App\Http\Controllers\Evaluations\EvaluationsController@saveAttachments');
        });
        Route::group(['prefix' => 'logs'],function (){
            Route::post('getLogs','App\Http\Controllers\Logs\logsController@getLogs');
        });
        Route::group(['prefix' => 'roles'],function (){
            Route::post('getAllRoles','App\Http\Controllers\Roles\RolesController@getAllRoles');
        });
        Route::group(['prefix' => 'emails'],function (){
            Route::post('storeEmailsByBulkFile','App\Http\Controllers\Emails\EmailsController@storeEmailsByBulkFile');
            Route::post('sendEvaluationMailToUserByDocument','App\Http\Controllers\Emails\EmailsController@sendEvaluationMailToUserByDocument');
            Route::post('sendEvaluationsMailsToMultipleUsers','App\Http\Controllers\Emails\EmailsController@sendEvaluationsMailsToMultipleUsers');
        });
    });

    Route::group(['prefix' => 'users'],function (){
        Route::post('getUser','App\Http\Controllers\Users\UsersController@getUser');
        Route::post('updatePersonalData','App\Http\Controllers\Users\UsersController@updatePersonalData');
    });

    Route::group(['prefix' => 'evaluations'],function (){
        Route::post('getEvaluations','App\Http\Controllers\Evaluations\EvaluationsController@getEvaluations');
        Route::post('downloadFileByFilename','App\Http\Controllers\Evaluations\EvaluationsController@downloadFileByFilename');
        Route::post('downloadFilesByBulkFile','App\Http\Controllers\Evaluations\EvaluationsController@downloadFilesByBulkFile');
    });

    Route::group(['prefix' => 'roles'],function (){
        Route::post('getPermissions','App\Http\Controllers\Roles\RolesController@getPermissions');
    });
});
