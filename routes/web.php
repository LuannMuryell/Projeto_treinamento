<?php

use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/home', function () {
    return Inertia::render('Home');
})->name('home');

// Pessoas
Route::get('/pessoas', [PeopleController::class, 'index'])->name('people.index');
Route::get('/pessoas/cadastro', [PeopleController::class, 'create'])->name('people.create');
Route::post('/pessoas', [PeopleController::class, 'store'])->name('people.store')->middleware([HandlePrecognitiveRequests::class]);
Route::get('/pessoas/{id}', [PeopleController::class, 'edit'])->name('people.edit');
Route::put('/pessoas/{id}', [PeopleController::class, 'update'])->name('people.update')->middleware([HandlePrecognitiveRequests::class]);
Route::delete('/pessoas/{id}', [PeopleController::class, 'destroy'])->name('people.destroy')->middleware([HandlePrecognitiveRequests::class]);

// Imóveis
Route::get('/imoveis', [PropertiesController::class, 'index'])->name('properties.index');
Route::get('/imoveis/cadastro', [PropertiesController::class, 'create'])->name('properties.create');
Route::post('/imoveis', [PropertiesController::class, 'store'])->name('properties.store')->middleware([HandlePrecognitiveRequests::class]);
Route::get('/imoveis/{ins_municipal}', [PropertiesController::class, 'edit'])->name('properties.edit');
Route::put('/imoveis/{ins_municipal}', [PropertiesController::class, 'update'])->name('properties.update')->middleware([HandlePrecognitiveRequests::class]);
Route::delete('/imoveis/{ins_municipal}', [PropertiesController::class, 'destroy'])->name('properties.destroy')->middleware([HandlePrecognitiveRequests::class]);

Route::delete('/imoveis/delete{id}', [PropertiesController::class, 'destroyFile'])->name('files.destroy')->middleware([HandlePrecognitiveRequests::class]);
Route::post('/imoveis/{ins_municipal}/upload', [PropertiesController::class, 'uploadFile'])->name('files.upload')->middleware([HandlePrecognitiveRequests::class]);
Route::get('/imoveis/download-{id}', [PropertiesController::class, 'downloadFile'])->name('files.download');



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

