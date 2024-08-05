<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

# Agregamos la siguiente ruta
Volt::route('user', 'admin.user.index')
    ->middleware(['auth'])
    ->name('user.index');

require __DIR__ . '/auth.php';