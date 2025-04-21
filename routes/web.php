<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TypeRoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::patch('/reservations/{reservation}/status', [ReservationController::class, 'changeStatus'])->name('reservations.updateStatus');

    Route::resource('type-room', TypeRoomController::class);

    Route::resource('room', RoomController::class);
    Route::patch('/rooms/{room}/status', [RoomController::class, 'changeStatus'])->name('rooms.updateStatus');

    Route::get('user-management', [UserController::class, 'index'])->name('user-management.index');
    Route::delete('user-management/{id}', [UserController::class, 'destroy'])->name('user-management.destroy');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/room-User/{id}', [HomeController::class, 'show'])->name('home.show');

    Route::get('/room-User/{id}/reservation', [HomeController::class, 'Reservation'])->name('reservation.room');

    Route::get('/my-reservations', [ReservationController::class, 'userReservations'])
        ->name('reservations.user');
    Route::patch('/my-reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');


    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::post('/midtrans/callback', [ReservationController::class, 'callback'])->name('midtrans.callback');
});


require __DIR__ . '/auth.php';
