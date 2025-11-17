<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

Route::prefix('reservations')->name('reservations.')->group(function () {
    // Show the reservation form
    Route::get('/', [ReservationController::class, 'create'])->name('create');
    Route::post('/store', [ReservationController::class, 'store'])->name('store');
    Route::get('/graph',[ReservationController::class, 'showGraph']);
});
