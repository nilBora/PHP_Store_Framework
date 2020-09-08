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
Route::post('/auth/login', 'AuthController@onLogin');
Route::get('/auth/user', 'AuthController@getUserInfo');

Route::get('/{name}', 'ApiDefault@index')->where('name', '[A-Za-z]+');

Route::get('/{name}/{id}', 'ApiDefault@show')->where('name', '[A-Za-z]+')->where(['id' => '[0-9]+']);

Route::post('/{name}', 'ApiDefault@store')->where('name', '[A-Za-z]+');

Route::post('/{name}/{id}', 'ApiDefault@update')->where('name', '[A-Za-z]+')->where(['id' => '[0-9]+']);

Route::delete('/{name}/{id}', 'ApiDefault@remove')->where('name', '[A-Za-z]+')->where(['id' => '[0-9]+']);
