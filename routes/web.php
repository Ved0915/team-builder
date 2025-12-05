<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlayerAssignmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\RedirectResponse;

Route::get('/', function (): RedirectResponse {
    if (auth()->check()) {
        return to_route('dashboard');
    }

    return to_route('login');
})->name('home');

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('player-assignments', [PlayerAssignmentController::class, 'index'])
        ->name('player-assignments.index');

    Route::post('player-assignments', [PlayerAssignmentController::class, 'store'])
        ->name('player-assignments.store');
});

require __DIR__.'/settings.php';
