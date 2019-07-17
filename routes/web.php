<?php

Auth::routes();

Route::get('/', 'DashboardController@index');

Route::apiResource('/tasks', 'TaskController');
