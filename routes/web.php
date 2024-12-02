<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ArticuloController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('articulos', ArticuloController::class);
Route::resource('facturas', FacturaController::class);
Route::post('/facturas/{factura}/add-articulo', [FacturaController::class, 'addArticulo'])->name('facturas.addArticulo');
Route::get('/facturas/{factura}/articulos', [FacturaController::class, 'showArticulos'])->name('facturas.showArticulos');


require __DIR__.'/auth.php';
