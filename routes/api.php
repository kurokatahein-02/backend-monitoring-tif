<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoriController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PihakKetigaController;
use App\Http\Controllers\SitacController;
use App\Http\Controllers\DashboardController; // Jangan lupa tambahkan ini di atas!

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::apiResource('inventori', InventoriController::class);
    Route::apiResource('unit', UnitController::class);
    Route::apiResource('kegiatan', KegiatanController::class);
    Route::apiResource('pihak-ketiga', PihakKetigaController::class);
    Route::apiResource('sitac', SitacController::class);
    
    // Route khusus untuk Dashboard (hanya butuh metode GET)
    Route::get('/dashboard', [DashboardController::class, 'index']);
});