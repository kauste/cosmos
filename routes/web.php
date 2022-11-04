<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MineController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//countries
Route::prefix('countries')->name('country-')->group(function () {
Route::get('/', [CountryController::class, 'index'])->name('list');
Route::get('/create', [CountryController::class, 'create'])->name('create');
Route::post('/store', [CountryController::class, 'store'])->name('store');
Route::get('/edit/{country}', [CountryController::class, 'edit'])->name('edit');
Route::put('/update/{country}', [CountryController::class, 'update'])->name('update');
Route::delete('/delete/{country}', [CountryController::class, 'destroy'])->name('delete');
});

//mines
Route::prefix('mines')->name('mine-')->group(function () {
    Route::get('/', [MineController::class, 'index'])->name('list');
    Route::get('/create', [MineController::class, 'create'])->name('create');
    Route::post('/store', [MineController::class, 'store'])->name('store');
    Route::get('/create-for-country/{country}', [MineController::class, 'create'])->name('create-for-country');
    Route::get('/edit/{mine}', [MineController::class, 'edit'])->name('edit');
    Route::put('/update/{mine}', [MineController::class, 'update'])->name('update');
    Route::delete('/delete/{mine}', [MineController::class, 'destroy'])->name('delete');
    });