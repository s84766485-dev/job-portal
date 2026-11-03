<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Employer;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job:slug}', [JobController::class, 'show'])->name('jobs.show');

// Guests
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Any signed-in user
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});

// Candidates
Route::middleware(['auth', 'role:candidate'])->group(function () {
    Route::post('/jobs/{job:slug}/apply', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/my-applications', [ApplicationController::class, 'mine'])->name('candidate.applications');
    Route::delete('/my-applications/{application}', [ApplicationController::class, 'withdraw'])->name('candidate.applications.withdraw');
});

// Employers
Route::middleware(['auth', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [Employer\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/company', [Employer\CompanyController::class, 'edit'])->name('company.edit');
    Route::put('/company', [Employer\CompanyController::class, 'update'])->name('company.update');

    Route::resource('jobs', Employer\JobController::class)->except('show');
    Route::get('/jobs/{job}/applicants', [Employer\ApplicantController::class, 'index'])->name('jobs.applicants');
    Route::patch('/applications/{application}', [Employer\ApplicantController::class, 'update'])->name('applications.update');
    Route::get('/applications/{application}/resume', [Employer\ApplicantController::class, 'resume'])->name('applications.resume');
});

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle', [Admin\UserController::class, 'toggle'])->name('users.toggle');
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/jobs', [Admin\JobController::class, 'index'])->name('jobs.index');
    Route::patch('/jobs/{job}/feature', [Admin\JobController::class, 'feature'])->name('jobs.feature');
    Route::patch('/jobs/{job}/status', [Admin\JobController::class, 'status'])->name('jobs.status');
    Route::delete('/jobs/{job}', [Admin\JobController::class, 'destroy'])->name('jobs.destroy');

    Route::get('/categories', [Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
});
