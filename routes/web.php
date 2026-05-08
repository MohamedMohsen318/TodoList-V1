<?php

use App\Http\Controllers\Admin\AdminAndRoleController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskMangerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');

    Route::view('/reset-password/{token}', 'auth.reset-password')->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('user.dashboard');

    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskMangerController::class, 'listTask'])->name('index');
        Route::get('/create', [TaskMangerController::class, 'addTask'])->name('create');
        Route::post('/', [TaskMangerController::class, 'addTaskPost'])->name('store');
        Route::get('/{id}/status', [TaskMangerController::class, 'updateTaskStats'])->name('status.update');
        Route::get('/{id}/delete', [TaskMangerController::class, 'deleteTask'])->name('delete');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.attempt');

        Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPassword'])->name('password.request');
        Route::post('/forgot-password', [AdminAuthController::class, 'forgotPassword'])->name('password.email');

        Route::get('/reset-password/{token}', [AdminAuthController::class, 'showResetPassword'])->name('password.reset');
        Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('password.update');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [AdminAndRoleController::class, 'rolesIndex'])->name('index');
            Route::get('/create', [AdminAndRoleController::class, 'rolesCreate'])->name('create');
            Route::post('/', [AdminAndRoleController::class, 'rolesStore'])->name('store');
            Route::get('/{role}/edit', [AdminAndRoleController::class, 'rolesEdit'])->name('edit');
            Route::put('/{role}', [AdminAndRoleController::class, 'rolesUpdate'])->name('update');
            Route::delete('/{role}', [AdminAndRoleController::class, 'rolesDestroy'])->name('destroy');
        });

        Route::prefix('admins')->name('admins.')->group(function () {
            Route::get('/', [AdminAndRoleController::class, 'adminsIndex'])->name('index');
            Route::get('/create', [AdminAndRoleController::class, 'adminsCreate'])->name('create');
            Route::post('/', [AdminAndRoleController::class, 'adminsStore'])->name('store');
            Route::get('/{admin}/edit', [AdminAndRoleController::class, 'adminsEdit'])->name('edit');
            Route::put('/{admin}', [AdminAndRoleController::class, 'adminsUpdate'])->name('update');
            Route::delete('/{admin}', [AdminAndRoleController::class, 'adminsDestroy'])->name('destroy');
        });
    });
});
