<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
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

Route::get('/', [SiteController::class, 'index'])->name("home");
Route::get('/regulamento', [SiteController::class, 'regulamento'])->name("regulamento");
Route::get('/termos-de-uso', [SiteController::class, 'termos'])->name("termos");
