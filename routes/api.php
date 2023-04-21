<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\MarcacionesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("login",[LoginController::class,"login"])->name("login");

Route::prefix("marcaciones")->name("marcaciones.")->middleware("auth:sanctum")->group(function(){
    Route::post("",[MarcacionesController::class,"store"])->name("store");
    Route::get("", [MarcacionesController::class,"index"])->name("index");
});