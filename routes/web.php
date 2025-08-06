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
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Переопределяем маршруты

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->middleware('custom.csrf');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('custom.csrf');
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->middleware('custom.csrf');

Auth::routes(['register' => false, 'login' => false,'reset'=> true, ] ); 
// Главная страница для всех
Route::get('/', [HomeController::class, 'index'])->name('home');

// Публичный просмотр объекта
Route::get('/properties/{property}', [PublicPropertyController::class, 'show'])->name('properties.show');
Route::get('/properties', [PublicPropertyController::class, 'index'])->name('properties.index');

// Обратная связь (форма + обработка) — доступно всем
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Статические публичные страницы
Route::get('/consultation', [PageController::class, 'consultation'])->name('consultation');
Route::get('/services/real-estate', [PageController::class, 'realEstateService'])->name('services.real_estate');
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');

// Авторизованные пользователи
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings/profile', [ProfileController::class, 'index'])->name('settings.profile');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{property}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::post('/purchase-requests/{property}', [FavoriteController::class, 'createPurchaseRequest'])->name('purchase-requests.store');
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

    // Управление заявками (контакты)
    Route::get('/contacts', [PropertyController::class, 'contacts'])->name('dashboard.contacts.index');
    Route::delete('/contacts/{contact}', [PropertyController::class, 'destroy'])->name('dashboard.contacts.destroy');

    // Управление заявками на покупку
    Route::get('/purchase-requests', [DashboardController::class, 'purchaseRequests'])->name('dashboard.purchase-requests.index');
    Route::delete('/dashboard/purchase-requests/{purchaseRequest}', [DashboardController::class, 'destroyPurchaseRequest'])
        ->name('dashboard.purchase-requests.destroy');

    // Админ-настройки
    Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy.policy');
    Route::put('/phone/update', [DashboardController::class, 'updatePhone'])->name('dashboard.phone.update');
    Route::put('/email/update', [DashboardController::class, 'updateEmail'])->name('dashboard.email.update');
    Route::put('/dashboard/banner/update', [DashboardController::class, 'updateBannerText'])->name('dashboard.banner.update');
});