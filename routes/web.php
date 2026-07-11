<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\GrievanceController as AdminGrievanceController;
use App\Http\Controllers\Citizen\DashboardController as CitizenDashboardController;
use App\Http\Controllers\Citizen\GrievanceController as CitizenGrievanceController;
use App\Http\Controllers\Officer\DashboardController as OfficerDashboardController;
use App\Http\Controllers\Officer\GrievanceController as OfficerGrievanceController;

Route::get('/', function () {
    return view('auth.login');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // Citizen routes
    Route::middleware('role:citizen')->prefix('citizen')->name('citizen.')->group(function () {
        Route::get('dashboard', [CitizenDashboardController::class, 'index'])->name('dashboard');
        Route::get('grievances', [CitizenGrievanceController::class, 'index'])->name('grievances.index');
        Route::get('grievances/create', [CitizenGrievanceController::class, 'create'])->name('grievances.create');
        Route::post('grievances', [CitizenGrievanceController::class, 'store'])->name('grievances.store');
        Route::get('grievances/{grievance}', [CitizenGrievanceController::class, 'show'])->name('grievances.show');
        Route::post('grievances/{grievance}/comments', [CitizenGrievanceController::class, 'addComment'])->name('grievances.comment');
    });

    // Officer routes
    Route::middleware('officer')->prefix('officer')->name('officer.')->group(function () {
        Route::get('dashboard', [OfficerDashboardController::class, 'index'])->name('dashboard');
        Route::get('grievances', [OfficerGrievanceController::class, 'index'])->name('grievances.index');
        Route::get('grievances/{grievance}', [OfficerGrievanceController::class, 'show'])->name('grievances.show');
        Route::post('grievances/{grievance}/assign', [OfficerGrievanceController::class, 'assignToMe'])->name('grievances.assign');
        Route::post('grievances/{grievance}/status', [OfficerGrievanceController::class, 'updateStatus'])->name('grievances.status');
        Route::post('grievances/{grievance}/comments', [OfficerGrievanceController::class, 'addComment'])->name('grievances.comment');
    });

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::get('departments', [AdminDepartmentController::class, 'index'])->name('departments.index');
        Route::post('departments', [AdminDepartmentController::class, 'store'])->name('departments.store');
        Route::put('departments/{department}', [AdminDepartmentController::class, 'update'])->name('departments.update');
        Route::delete('departments/{department}', [AdminDepartmentController::class, 'destroy'])->name('departments.destroy');

        Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::put('categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('grievances', [AdminGrievanceController::class, 'index'])->name('grievances.index');
        Route::get('grievances/{grievance}', [AdminGrievanceController::class, 'show'])->name('grievances.show');
        Route::post('grievances/{grievance}/assign', [AdminGrievanceController::class, 'assign'])->name('grievances.assign');
        Route::post('grievances/{grievance}/status', [AdminGrievanceController::class, 'updateStatus'])->name('grievances.status');
    });
});
