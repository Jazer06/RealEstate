<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\PropertyController;
use App\Http\Controllers\Dashboard\ProfileController;

Auth::routes();

// Главная страница для всех
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Профиль для всех авторизованных пользователей
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile'); // Изменил имя маршрута
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Изменил имя маршрута
});

// Панель администратора
Route::middleware(['auth', 'admin'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::resource('properties', PropertyController::class)->names([
        'index' => 'dashboard.properties.index',
        'create' => 'dashboard.properties.create',
        'store' => 'dashboard.properties.store',
        'show' => 'dashboard.properties.show',
        'edit' => 'dashboard.properties.edit',
        'update' => 'dashboard.properties.update',
        'destroy' => 'dashboard.properties.destroy',
    ]);
});