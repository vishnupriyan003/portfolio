<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');
Route::post('/contact', [PortfolioController::class, 'storeContact'])->name('contact.store');

Route::get('/vpadmin', [AdminController::class, 'login'])->name('admin.login');
Route::post('/vpadmin', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/vpadmin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/vpadmin/settings', [AdminController::class, 'settings'])->name('admin.settings');
Route::post('/vpadmin/settings', [AdminController::class, 'update'])->name('admin.update');
