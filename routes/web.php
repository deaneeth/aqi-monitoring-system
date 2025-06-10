<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\SysAdminController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PublicMapController;
use App\Http\Controllers\SimulationSettingController;
use App\Http\Controllers\Admin\AlertsController;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🌐 Public Routes
Route::get('/', [PublicMapController::class, 'index'])->name('home');
Route::get('/public-map', [PublicMapController::class, 'index'])->name('public.map');
Route::get('/map', [MapController::class, 'publicMap'])->name('map.public');

// 📥 Data Upload (Admin only, but outside middleware for now)
Route::get('/admin/upload-data', [AdminController::class, 'showUploadForm'])->name('data.upload.form');
Route::post('/admin/upload-data', [AdminController::class, 'handleCsvUpload'])->name('data.upload.handle');

// 🔐 Authenticated User Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🔐 Admin Only Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Sensor Management
    Route::resource('/sensors', SensorController::class);
    Route::post('/sensors/{id}/activate', [SensorController::class, 'activate'])->name('sensors.activate');
    Route::delete('/sensors/{id}/force-delete', [SensorController::class, 'forceDelete'])->name('sensors.forceDelete');
    Route::get('/sensor-map', [SensorController::class, 'map'])->name('sensors.map');

    // Simulation Settings
    Route::get('/simulation-settings', [SimulationSettingController::class, 'index'])->name('simulation.settings');
    Route::post('/simulation-settings', [SimulationSettingController::class, 'update'])->name('simulation.settings.update');

    // Alerts
    Route::get('/alerts', [AlertsController::class, 'index'])->name('admin.alerts.index');

    // Admin User Management
    Route::resource('/users', UserManagementController::class)->names('admin.users');
});

// 🔐 System Admin Routes
Route::middleware(['auth', 'role:sysadmin'])->prefix('sysadmin')->group(function () {
    Route::get('/dashboard', [SysAdminController::class, 'index'])->name('sysadmin.dashboard');
});

// 🛡️ Role-Based Redirect for All Authenticated Users
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'sysadmin') {
        return redirect()->route('sysadmin.dashboard');
    } else {
        return redirect()->route('home');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Authentication Routes
require __DIR__.'/auth.php';
