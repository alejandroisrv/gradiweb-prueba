<?php

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

Route::get('/brands', 'VehiclesController@getBrands');
Route::get('/vehicles', 'VehiclesController@searchVehicle');
Route::post('/vehicle', 'VehiclesController@addNewVehicle');
Route::post('/brand/update/{id}', 'VehiclesController@updateBrand');
