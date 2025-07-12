<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\PropertyController;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::resource('properties', PropertyController::class)
        ->names([
            'index' => 'dashboard.properties.index', // Теперь route('dashboard.properties.index') будет работать
            'create' => 'dashboard.properties.create',
            'store' => 'dashboard.properties.store',
            'show' => 'dashboard.properties.show',
            'edit' => 'dashboard.properties.edit',
            'update' => 'dashboard.properties.update',
            'destroy' => 'dashboard.properties.destroy',
        ]);
});