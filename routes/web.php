<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitorController;

// Main Dashboard
Route::get('/', [VisitorController::class, 'index'])->name('visitors.index');

// CRUD Actions
Route::post('/visitors', [VisitorController::class, 'store'])->name('visitors.store');
Route::put('/visitors/{visitor}', [VisitorController::class, 'update'])->name('visitors.update');
Route::delete('/visitors/{visitor}', [VisitorController::class, 'destroy'])->name('visitors.destroy');