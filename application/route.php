<?php
use think\Route;

// Sheet
Route::get('api/:version/sheet/:id', 'api/:version.Sheet/getSheet',[], ['id'=>'\d+']);
Route::post('api/:version/sheet', 'api/:version.Sheet/createSheet');

// Work
Route::get('api/:version/work/:id', 'api/:version.Work/getWork', [], ['id'=>'\d+']);
Route::post('api/:version/work', 'api/:version.Work/createWork');

// User
Route::get('api/:version/user', 'api/:version.User/getUser');
Route::post('api/:version/user', 'api/:version.User/addOrUpdateUser');

// Token
Route::post('api/:version/token/user', 'api/:version.Token/getToken');
Route::post('api/:version/token/verify', 'api/:version.Token/verifyToken');
