<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\RoomTypeController as AdminRoomTypeController;
use App\Http\Controllers\Admin\LogController as AdminLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/admin/get-room-details/{id}', [BookingController::class, 'getRoomDetails'])
    ->name('bookings.get-room-details');

    Route::get('/get-room-types/{location_id}', [BookingController::class, 'getRoomTypes']);
    Route::get('bookings/available-rooms', [BookingController::class, 'getAvailableRooms'])->name('bookings.available-rooms');
    Route::get('bookings/get-rooms', [BookingController::class, 'getRooms'])->name('bookings.get-rooms');
    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update']);

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware(['admin'])->group(function () {
            Route::get('logs', [AdminLogController::class, 'index'])->name('logs.index');
            Route::resource('users', AdminUserController::class);
        });

        Route::resource('locations', AdminLocationController::class);
        Route::resource('rooms', AdminRoomController::class);
        Route::resource('room-types', AdminRoomTypeController::class);

    });

});

require __DIR__.'/auth.php';
