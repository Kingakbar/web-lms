<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardAdminController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', fn() => view('pages.auth.login_page'))->name('login');
Route::get('/register', fn() => view('pages.auth.register_page'))->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard/student', fn() => view('pages.dashboard.dashboard_student'))->name('dashboard.student');
});

Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/dashboard/instructor', fn() => view('pages.dashboard.dashboard_instructor'))->name('dashboard.instructor');
});


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard/admin', [DashboardAdminController::class, 'index'])->name('dashboard.admin');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
});
