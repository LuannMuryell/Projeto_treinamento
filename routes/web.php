<?php

use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AverbacoesController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {

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

// Arquivos
Route::delete('/imoveis/delete{id}', [PropertiesController::class, 'destroyFile'])->name('files.destroy')->middleware([HandlePrecognitiveRequests::class]);
Route::post('/imoveis/{ins_municipal}/upload', [PropertiesController::class, 'uploadFile'])->name('files.upload')->middleware([HandlePrecognitiveRequests::class]);
Route::get('/imoveis/download-{id}', [PropertiesController::class, 'downloadFile'])->name('files.download');

// Usuários
Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
Route::get('/usuarios/cadastro', [UserController::class, 'create'])->name('users.create');
Route::post('/usuarios', [UserController::class, 'store'])->name('users.store')->middleware([HandlePrecognitiveRequests::class]);

// Averbações

Route::get('/imoveis/visualizar/averbacao/{ins_municipal}', [AverbacoesController::class, 'index'])->name('averbacoes.index');
Route::get('/imoveis/registrar-averbacao/imovel-{ins_municipal}', [AverbacoesController::class, 'create'])->name('averbacoes.create');
Route::post('/imoveis/averbacoes', [AverbacoesController::class, 'store'])->name('averbacoes.store')->middleware([HandlePrecognitiveRequests::class]);

});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

