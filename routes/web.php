<?php

use App\Http\Controllers\PeopleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Authentication');
}); // Aqui será a página de autenticação

Route::get('/home', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/pessoas', [PeopleController::class, 'index'])->name('pessoas.index');
Route::get('/cadastro_pessoas', [PeopleController::class, 'create'])->name('people.create');