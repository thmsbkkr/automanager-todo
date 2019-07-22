<?php

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', 'DashboardController@index');

    Route::apiResource('tasks', 'TaskController')->only(['index', 'store', 'update', 'destroy']);

    Route::post('/tasks/{task}/toggle', 'TaskController@toggle');
    Route::post('/tasks/toggle/active', 'TaskController@markAllActive');
    Route::post('/tasks/toggle/complete', 'TaskController@markAllCompleted');
});
