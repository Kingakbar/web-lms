<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ClientSideController;
use App\Http\Controllers\CourseAdminController;
use App\Http\Controllers\TranscationController;
use App\Http\Controllers\CourseStudentController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardStudentController;
use App\Http\Controllers\CourseInsctructorController;
use App\Http\Controllers\DashboardInstructorController;


Route::get('/', [ClientSideController::class, 'index'])->name('home');


Route::get('/login', fn() => view('pages.auth.login_page'))->name('login');
Route::get('/register', fn() => view('pages.auth.register_page'))->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard/student', [DashboardStudentController::class, 'index'])->name('dashboard.student');
    Route::resource('/courses_student', CourseStudentController::class)->parameters([
        'courses' => 'course:slug'
    ]);
    Route::get('/learn/{course:slug}/lesson/{lesson:slug}', [CourseStudentController::class, 'lesson'])->name('learn.lesson');
    Route::post('/learn/{course}/{lesson}/complete', [CourseStudentController::class, 'completeLesson'])
        ->name('learn.lesson.complete');

    Route::get('/learn/{course}/quiz/{quiz}', [CourseStudentController::class, 'quiz'])->name('learn.quiz');
    Route::post('/learn/{course}/quiz/{quiz}/submit', [CourseStudentController::class, 'submitQuiz'])->name('learn.quiz.submit');
    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
    Route::get('/certificates', [CertificateController::class, 'index'])
        ->name('certificates.index');

    // Generate & download sertifikat
    Route::get('/certificates/{enrollmentId}/generate', [CertificateController::class, 'generate'])
        ->name('certificates.generate');
});

Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/dashboard/instructor', [DashboardInstructorController::class, 'index'])->name('dashboard.instructor');
    Route::resource('/courses_instructor', CourseInsctructorController::class)->parameters([
        'courses' => 'course:slug'
    ]);
    Route::resource('lessons', LessonController::class)->parameters([
        'lessons' => 'lesson:slug'
    ]);
    Route::resource('quizzes', QuizController::class);
    Route::get('/enrollments', [EnrollmentController::class, 'index'])
        ->name('instructor.enrollments.index');

    Route::get('/reviews', [ReviewController::class, 'index'])->name('instructor.reviews.index');
});


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard/admin', [DashboardAdminController::class, 'index'])->name('dashboard.admin');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::resource('/categories', CategoryController::class)->parameters([
        'categories' => 'category:slug'
    ]);

    Route::resource('/courses', CourseAdminController::class)->parameters([
        'courses' => 'course:slug'
    ]);

    Route::resource('/transactions', TranscationController::class)->parameters([
        'transactions' => 'transaction:id'
    ]);
    Route::resource('/promos', PromoController::class)->parameters([
        'promos' => 'promo:slug'
    ]);

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
    });
});


Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingController::class, 'settingPage'])->name('settings.page');
    Route::put('/settings/profile', [SettingController::class, 'updateProfile'])->name('settings.updateProfile');
    Route::put('/settings/password', [SettingController::class, 'updatePassword'])->name('settings.updatePassword');
});
