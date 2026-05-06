<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskMangerController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/welcome', function () {
    return view('welcome');
})->middleware('auth')->name('welcome');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('showRegister');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/task/create', [TaskMangerController::class, 'addTask'])
        ->name('task.create');

    Route::post('/task/store', [TaskMangerController::class, 'addTaskPost'])
        ->name('task.store');

    Route::get('/task/list', [TaskMangerController::class, 'listTask'])
        ->name('task.index');

    Route::get('/task/status/{id}', [TaskMangerController::class, 'updateTaskStats'])
    ->name('task.status.update');

    Route::get('/task/delet/{id}', [TaskMangerController::class, 'deleteTask'])
        ->name('task.delet');

});
