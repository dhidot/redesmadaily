<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\HomeController;


Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        //Halaman Position
        Route::resource('/positions', PositionController::class)->only(['index', 'create']);
        Route::get('/positions/edit', [PositionController::class, 'edit'])->name('positions.edit');

        // employees
        Route::resource('/employees', EmployeeController::class)->only(['index', 'create']);
        Route::get('/employees/edit', [EmployeeController::class, 'edit'])->name('employees.edit');

        // holidays
        Route::resource('/holidays', HolidayController::class)->only(['index', 'create']);
        Route::get('/holidays/edit', [HolidayController::class, 'edit'])->name('holidays.edit');

        // attendances (Set Form Kehadiran Oleh Admin / HRD)
        Route::resource('/attendances', AttendanceController::class)->only(['index', 'create']);
        Route::get('/attendances/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');

        // Presence
        Route::resource('/presences', PresenceController::class)->only(['index']);
        Route::get('/presences/{attendance}', [PresenceController::class, 'show'])->name('presences.show');

        // not present data
        Route::get('/presences/{attendance}/not-present', [PresenceController::class, 'notPresent'])->name('presences.not-present');
        Route::post('/presences/{attendance}/not-present', [PresenceController::class, 'notPresent']);
    });

    Route::middleware('role:user')->name('home.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');

        // change password
        Route::get('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [HomeController::class, 'updatePassword'])->name('update-password');

        Route::get('/absensi/{attendance}', [HomeController::class, 'show'])->name('show');
    });

    Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware('guest')->group(function () {
    // auth
    Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});
