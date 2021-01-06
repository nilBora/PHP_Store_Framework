<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/render/edit/{name}/{id}', 'StoreViewController@show')->where('name', '[A-Za-z]+')->where(['id' => '[0-9]+']);
Route::get('/render/add/{name}', 'StoreViewController@onShowEmptyForm')->where('name', '[A-Za-z]+');
