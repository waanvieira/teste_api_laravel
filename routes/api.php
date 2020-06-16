<?php

use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
    // return $request->user();

Route::namespace('API')->name('api.')->group(function () {

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
    });

    Route::apiResource('user', 'UserController', ['only' => ['store']]);
    // Route::post('/reset_password', 'UserController@resetPassword')->name('reset_password');

    Route::group([
        'middleware' => 'api',
        'prefix' => 'password'
    ], function () {
        Route::post('create', 'PasswordResetController@create');
        Route::get('find/{token}', 'PasswordResetController@find');
        Route::post('reset', 'PasswordResetController@reset');
    });

    Route::middleware('jwt.auth')->group(function () {
        Route::apiResource('user', 'UserController', ['except' => ['store']]);
    });

});
