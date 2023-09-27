<?php

use App\Http\Controllers\InstaController;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\YtController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('data',[ScraperController::class,'index']);

Route::get('sdata',[InstaController::class,'index']);
Route::get('ytdata',[YtController::class,'index']);
