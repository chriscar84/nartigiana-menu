<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use Illuminate\Support\Facades\Route;


//FRONTEND
Route::get('/menu/{menu}', [\App\Http\Controllers\PublicMenuController::class, 'show'])->name('public.menu');
//Route::get('/menu/{menu:slug}', [\App\Http\Controllers\PublicMenuController::class, 'show'])->name('public.menu');


//BACKEND
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
	Route::get('/menus/import', [MenuController::class, 'showImportForm'])->name('menus.import.form');
	Route::post('/menus/import', [MenuController::class, 'import'])->name('menus.import');
	
    Route::resource('menus', MenuController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('dishes', DishController::class);
	
});
require __DIR__.'/auth.php';
