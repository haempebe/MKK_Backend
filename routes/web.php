<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
    return view('guests.home');
})->name('home');

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::controller(FilmController::class)->group(function () {
        Route::get('/films', 'index')->name('films');
        Route::get('/show/{id}', 'show')->name('films.show');
        Route::post('/films/create', 'store')->name('films.perform');
        Route::get('/films/edit/{id}', 'edit')->name('films.edit');
        Route::put('/films/edit/{id}', 'update')->name('films.update');
        Route::delete('films/{id}', 'destroy')->name('films.delete');
    });
    Route::controller(GenreController::class)->group(function () {
        Route::get('/genres', 'index')->name('genres');
        Route::post('/genres', 'store')->name('genres.perform');
        Route::get('/genres/edit/{id}', 'edit')->name('genres.edit');
        Route::put('/genres/edit/{id}', 'update')->name('genres.update');
        Route::delete('genres/{id}', 'destroy')->name('genres.delete');
    });
});
