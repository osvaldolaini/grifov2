<?php

use App\Http\Controllers\DocumentPdfController;
use App\Http\Controllers\FactPdfController;
use App\Http\Controllers\RegisterPdfController;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/', Home::class)->name('dashboard');
Route::get('/login', Home::class)->name('login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', Home::class)->name('dashboard');
    Route::get('pdf-fact/{fact}', FactPdfController::class)->name('pdf-fact');
    Route::get('pdf-register/{register}', RegisterPdfController::class)->name('pdf-register');
    Route::get('pdf-document/{document}', DocumentPdfController::class)->name('pdf-document');
});
