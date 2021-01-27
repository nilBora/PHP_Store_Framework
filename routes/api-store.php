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

Route::get('/{name}', 'DashboardApi@index')->where('name', '[A-Za-z]+');

Route::get('/{name}/{id}', 'DashboardApi@show')->where('name', '[A-Za-z]+')->where(['id' => '[0-9]+']);

Route::post('/{name}', 'DashboardApi@store')->where('name', '[A-Za-z]+');

Route::post('/{name}/{id}', 'DashboardApi@update')->where('name', '[A-Za-z]+')->where(['id' => '[0-9]+']);

Route::delete('/{name}/{id}', 'DashboardApi@remove')->where('name', '[A-Za-z]+')->where(['id' => '[0-9]+']);
