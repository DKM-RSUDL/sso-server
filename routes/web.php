<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OAuthClientController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// AUTH
Route::controller(AuthController::class)->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/logout', 'logout')->name('logout');
        Route::get('/authorize', [AuthController::class, 'authorize'])->name('authorize');
        Route::post('/authorize', [AuthController::class, 'approve'])->name('authorize.approve');
    });
});

// CLIENT
Route::controller(OAuthClientController::class)->group(function () {
    Route::prefix('client')->group(function () {
        Route::name('client')->group(function () {
            Route::middleware(['auth', AdminOnly::class])->group(function () {
                Route::get('/', 'index')->name('.index');
                Route::get('/create', 'create')->name('.create');
                Route::post('/', 'store')->name('.store');
                Route::put('/', 'update')->name('.update');
                Route::delete('/', 'delete')->name('.delete');
            });
        });
    });
});

// User
Route::controller(UserController::class)->group(function () {
    Route::prefix('user')->group(function () {
        Route::name('user')->group(function () {
            Route::middleware(['auth', AdminOnly::class])->group(function () {
                Route::get('/', 'index')->name('.index');
                Route::get('/create', 'create')->name('.create');
                Route::get('/{data}/edit', 'edit')->name('.edit');
                Route::post('/', 'store')->name('.store');
                Route::put('/{data}', 'update')->name('.update');
                Route::delete('/', 'delete')->name('.delete');
            });
        });
    });
});
