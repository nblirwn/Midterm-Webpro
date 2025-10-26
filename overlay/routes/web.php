<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublicController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('notes.index')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/public/n/{token}', [PublicController::class, 'show'])->name('public.note');

Route::middleware('auth')->group(function () {
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');
    Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    Route::post('/notes/{note}/pin', [NoteController::class, 'togglePin'])->name('notes.pin');
    Route::post('/notes/{note}/archive', [NoteController::class, 'archive'])->name('notes.archive');
    Route::post('/notes/{note}/restore', [NoteController::class, 'restore'])->name('notes.restore');
    Route::post('/notes/{note}/share', [NoteController::class, 'share'])->name('notes.share');
    Route::post('/notes/{note}/unshare', [NoteController::class, 'unshare'])->name('notes.unshare');

    Route::resource('categories', CategoryController::class)->except(['show']);
});
