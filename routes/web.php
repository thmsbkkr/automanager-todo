<?php

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', 'DashboardController@index');

    Route::apiResource('tasks', 'TaskController')->only(['index', 'store', 'update']);

    Route::post('/tasks/{task}/complete', 'TaskCompletionController@store');
    Route::post('/tasks/{task}/incomplete', 'TaskCompletionController@destroy');
});
