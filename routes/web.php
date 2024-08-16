<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::group(['middleware' => ['auth', 'permission:mostrar usuarios']], function () {
    Volt::route('users', 'admin.user.index');
});

Route::group(['middleware' => ['auth', 'permission:mostrar roles']], function () {
    Volt::route('roles', 'admin.role.index');
});

Route::group(['middleware' => ['auth', 'permission:mostrar permisos']], function () {
    Volt::route('permissions', 'admin.permission.index');
});

require __DIR__ . '/auth.php';