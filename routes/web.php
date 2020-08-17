<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "clarifaiController@index");
Route::get('/test', "clarifaiController@apparelDetection");

Route::post('/visual_search', "clarifaiController@visual_search");
