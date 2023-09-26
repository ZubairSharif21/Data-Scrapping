<?php

use App\Http\Controllers\InstaController;
use App\Http\Controllers\ScraperController;
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
Route::post('senddata',[InstaController::class,'index'])->name('senddata');
Route::get('data',[ScraperController::class,'index']);

Route::get('sdata',[InstaController::class,'index']);
