<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MineController;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\AllianceController;
use App\Http\Controllers\FirstPageController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Auth::routes(['register'=>false]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [FirstPageController::class, 'index'])->name('index');
Route::post('/email', [FirstPageController::class, 'email'])->name('email');
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
    Route::get('/create-for-country/{country}', [MineController::class, 'create'])->name('create-for-country');
    Route::post('/store', [MineController::class, 'store'])->name('store');
    Route::get('/edit/{mine}', [MineController::class, 'edit'])->name('edit');
    Route::put('/update/{mine}', [MineController::class, 'update'])->name('update');
    Route::delete('/delete/{mine}', [MineController::class, 'destroy'])->name('delete');
});
Route::get('show-longitude', [MineController::class, 'showLongitude'])->name('show-longitude');
Route::get('show-latitude', [MineController::class, 'showLatitude'])->name('show-latitude');
Route::get('show-country-and-ships', [MineController::class, 'showCountryAndShips'])->name('show-country-and-ships');

//ships
Route::prefix('ships')->name('ship-')->group(function () {
    Route::get('/', [ShipController::class, 'index'])->name('list');
    Route::get('/create', [ShipController::class, 'create'])->name('create');
    Route::get('/create-for-country/{country}', [ShipController::class, 'create'])->name('create-for-country');
    Route::post('/store', [ShipController::class, 'store'])->name('store');
    Route::get('/edit/{ship}', [ShipController::class, 'edit'])->name('edit');
    Route::put('/update/{ship}', [ShipController::class, 'update'])->name('update');
    Route::delete('/delete/{ship}', [ShipController::class, 'destroy'])->name('delete');
});
Route::get('show-country-and-mines', [ShipController::class, 'showCountryAndMines'])->name('show-country-and-mines');


//alliances
Route::prefix('alliances')->name('alliance-')->group(function () {
    Route::get('/', [AllianceController::class, 'index'])->name('list');
    Route::get('/create', [AllianceController::class, 'create'])->name('create');
    Route::get('/create-for-country/{country}', [AllianceController::class, 'create'])->name('create-for-country');
    Route::post('/store', [AllianceController::class, 'store'])->name('store');
    Route::get('/edit/{alliance}', [AllianceController::class, 'edit'])->name('edit');
    Route::put('/update/{alliance}', [AllianceController::class, 'update'])->name('update');
    Route::delete('/delete/{alliance}', [AllianceController::class, 'destroy'])->name('delete');
});