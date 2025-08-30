<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkSessionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::prefix('work-sessions')->name('work-sessions.')->group(function () {
        Route::get('/', [WorkSessionController::class, 'index'])->name('index');
        Route::get('/create', [WorkSessionController::class, 'create'])->name('create');
        Route::post('/', [WorkSessionController::class, 'store'])->name('store');
        Route::get('/{workSession}', [WorkSessionController::class, 'show'])->name('show');
        Route::get('/{workSession}/edit', [WorkSessionController::class, 'edit'])->name('edit');
        Route::put('/{workSession}', [WorkSessionController::class, 'update'])->name('update');
        Route::delete('/{workSession}', [WorkSessionController::class, 'destroy'])->name('destroy');
        Route::post('/{workSession}/end', [WorkSessionController::class, 'endSession'])->name('end');
        Route::post('/start', [WorkSessionController::class, 'startSession'])->name('start');
    });
    
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/create', [TaskController::class, 'create'])->name('create');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::get('/today', [TaskController::class, 'today'])->name('today');
        Route::get('/pending', [TaskController::class, 'pending'])->name('pending');
        Route::get('/{task}', [TaskController::class, 'show'])->name('show');
        Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
        Route::put('/{task}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
        Route::patch('/{task}/status', [TaskController::class, 'updateStatus'])->name('update-status');
    });
    
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/analytics', [ReportController::class, 'analytics'])->name('analytics');
        Route::post('/generate-weekly', [ReportController::class, 'generateWeekly'])->name('generate-weekly');
        Route::get('/{weeklyReport}', [ReportController::class, 'show'])->name('show');
    });
    
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::prefix('employees')->name('employees.')->group(function () {
            Route::get('/', [AdminController::class, 'employees'])->name('index');
            Route::get('/create', [AdminController::class, 'createEmployee'])->name('create');
            Route::post('/', [AdminController::class, 'storeEmployee'])->name('store');
            Route::get('/{employee}', [AdminController::class, 'showEmployee'])->name('show');
            Route::get('/{employee}/edit', [AdminController::class, 'editEmployee'])->name('edit');
            Route::put('/{employee}', [AdminController::class, 'updateEmployee'])->name('update');
        });
        
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [AdminController::class, 'companyReports'])->name('index');
        });
        
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    });
});

Route::fallback(function () {
    return redirect('/login');
});
