<?php

use Illuminate\Support\Facades\Route;
use Module\Infrastructure\Building\Http\Controllers\DeleteBuildingAction;
use Module\Infrastructure\Building\Http\Controllers\GetAllBuildingsAction;
use Module\Infrastructure\Building\Http\Controllers\GetBuildingAction;
use Module\Infrastructure\Building\Http\Controllers\SaveBuildingAction;

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

Route::get('/buildings/{companyId}', GetAllBuildingsAction::class);
Route::get('/building/{id}', GetBuildingAction::class);