<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Dashboard\PropertyController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PublicPropertyController;
use App\Http\Controllers\ContactController; 
use App\Http\Controllers\PageController; // Добавь этот

Auth::routes();

// Главная страница для всех
Route::get('/', [HomeController::class, 'index'])->name('home');

// Публичный маршрут для просмотра объекта
Route::get('/properties/{property}', [PublicPropertyController::class, 'show'])->name('properties.show');

// Форма обратной связи (для заявок)
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Новые страницы — Услуги и Контакты (публичные)
Route::get('/consultation', [PageController::class, 'consultation'])->name('consultation');
Route::get('/services/real-estate', [PageController::class, 'realEstateService'])->name('services.real_estate');
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts'); // Обрати внимание: contacts (мн.ч.)

// Профиль и избранное для авторизованных
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings/profile', [ProfileController::class, 'index'])->name('settings.profile');
    
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{property}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// Панель администратора
Route::middleware(['auth', 'admin'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('properties', PropertyController::class)->names([
        'index' => 'dashboard.properties.index',
        'create' => 'dashboard.properties.create',
        'store' => 'dashboard.properties.store',
        'show' => 'dashboard.properties.show',
        'edit' => 'dashboard.properties.edit',
        'update' => 'dashboard.properties.update',
        'destroy' => 'dashboard.properties.destroy',
    ]);

    Route::resource('sliders', SliderController::class)->names([
        'index' => 'dashboard.sliders.index',
        'create' => 'dashboard.sliders.create',
        'store' => 'dashboard.sliders.store',
        'edit' => 'dashboard.sliders.edit',
        'update' => 'dashboard.sliders.update',
        'destroy' => 'dashboard.sliders.destroy',
    ]);

    // Управление заявками
    Route::get('/contacts', [PropertyController::class, 'contacts'])->name('dashboard.contacts.index');
    Route::delete('/contacts/{contact}', [PropertyController::class, 'destroy'])->name('dashboard.contacts.destroy');
});