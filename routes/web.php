<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// pages de connexion/déconnexion
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// routes protégées par session utilisateur
Route::middleware('check.usersession')->group(function () {
    Route::get('/documents', [\App\Http\Controllers\DocumentController::class, 'index']);
    Route::get('/upload', [\App\Http\Controllers\DocumentController::class, 'create']);
    // ajouter d'autres routes /documents, /upload selon besoin
});
