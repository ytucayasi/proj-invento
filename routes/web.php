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
Volt::route('users', 'admin.user.index')
    ->middleware(['auth']);

# Agregamos la siguiente ruta para roles
Volt::route('roles', 'admin.role.index')
    ->middleware(['auth']);

require __DIR__ . '/auth.php';