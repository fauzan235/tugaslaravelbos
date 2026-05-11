<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Sistem Manajemen UKS SMKN 1 Purwokerto
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// ==========================================
// Guest Routes (belum login)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ==========================================
// Authenticated Routes (sudah login)
// ==========================================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (semua role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kunjungan / Treatment (Admin & Petugas bisa akses)
    Route::resource('treatments', TreatmentController::class)->only(['index', 'create', 'store', 'show']);

    // Lihat stok obat (semua role)
    Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');

    // ==========================================
    // Admin Only Routes
    // ==========================================
    Route::middleware('role:admin')->group(function () {
        // CRUD Kelas
        Route::resource('kelas', KelasController::class);

        // CRUD Siswa
        Route::resource('students', StudentController::class);

        // CRUD Obat (kecuali index, yang udah di atas)
        Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
        Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
        Route::get('/medicines/{medicine}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
        Route::put('/medicines/{medicine}', [MedicineController::class, 'update'])->name('medicines.update');
        Route::delete('/medicines/{medicine}', [MedicineController::class, 'destroy'])->name('medicines.destroy');

        // Tambah stok obat
        Route::get('/medicines/{medicine}/add-stock', [MedicineController::class, 'showAddStock'])->name('medicines.add-stock');
        Route::post('/medicines/{medicine}/add-stock', [MedicineController::class, 'addStock']);

        // Laporan
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});
