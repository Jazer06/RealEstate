<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Dashboard\PropertyController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\HomeController;

Auth::routes();

// Главная страница для всех
Route::get('/', [HomeController::class, 'index'])->name('home');

// Профиль для всех авторизованных пользователей
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings/profile', [ProfileController::class, 'index'])->name('settings.profile');
});

// Панель администратора
Route::middleware(['auth', 'admin'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Ресурс для недвижимости
    Route::resource('properties', PropertyController::class)->names([
        'index' => 'dashboard.properties.index',
        'create' => 'dashboard.properties.create',
        'store' => 'dashboard.properties.store',
        'show' => 'dashboard.properties.show',
        'edit' => 'dashboard.properties.edit',
        'update' => 'dashboard.properties.update',
        'destroy' => 'dashboard.properties.destroy',
    ]);

    // Ресурс для слайдера
    Route::resource('sliders', SliderController::class)->names([
        'index' => 'dashboard.sliders.index',
        'create' => 'dashboard.sliders.create',
        'store' => 'dashboard.sliders.store',
        'edit' => 'dashboard.sliders.edit',
        'update' => 'dashboard.sliders.update',
        'destroy' => 'dashboard.sliders.destroy',
    ]);
});