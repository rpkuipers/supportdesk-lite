<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    
    Route::get('tickets/my', [TicketController::class, 'myTickets'])
    ->name('tickets.my');

    Route::resource('tickets', TicketController::class);

    Route::post('tickets/{ticket}/resolve', [TicketController::class, 'resolve'])
        ->name('tickets.resolve');

    Route::post('tickets/{ticket}/reopen', [TicketController::class, 'reopen'])
        ->name('tickets.reopen');

    Route::post('tickets/{ticket}/selfassign', [TicketController::class, 'selfassign'])
        ->name('tickets.selfassign');
    
    Route::post('tickets/{ticket}/addNote', [TicketController::class, 'addNote'])
        ->name('tickets.addNote');
    Route::resource('categories', CategoryController::class)->except(['show']);
});
