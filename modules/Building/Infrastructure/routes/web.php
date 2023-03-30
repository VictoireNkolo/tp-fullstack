<?php

use Illuminate\Support\Facades\Route;
use TP\Building\Infrastructure\Http\Controllers\DeleteBuildingAction;
use TP\Building\Infrastructure\Http\Controllers\GetAllBuildingsAction;
use TP\Building\Infrastructure\Http\Controllers\GetBuildingAction;
use TP\Building\Infrastructure\Http\Controllers\SaveBuildingAction;

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

Route::post('/building/save', SaveBuildingAction::class);
Route::post('/building/delete', DeleteBuildingAction::class);

Route::get('/buildings', GetAllBuildingsAction::class);
Route::get('/building/{id}', GetBuildingAction::class);
