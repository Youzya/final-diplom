<?php

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

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\HallController::class, 'index'])->name('admin');
    Route::post('/add_hall', [App\Http\Controllers\HallController::class, 'store'])->name('add_hall');
    Route::post('/hall_activate', [App\Http\Controllers\HallController::class, 'activateHall'])->name('hall_activate');
    Route::post('/add_movie', [App\Http\Controllers\MovieController::class, 'store'])->name('add_movie');
    Route::post('/add_showtime', [App\Http\Controllers\ShowtimeController::class, 'store'])->name('add_showtime');
    Route::post('/update_seat_count', [App\Http\Controllers\HallController::class, 'updateSeatCount'])->name('update_seat_count');
    Route::post('/update_hall_price', [App\Http\Controllers\HallController::class, 'updatePrice'])->name('update_hall_price');
    Route::post('/update_hall_config', [App\Http\Controllers\HallConfigController::class, 'update'])->name('update_hall_config');
    Route::post('/delete_hall', [App\Http\Controllers\HallController::class, 'destroy'])->name('delete_hall');
    Route::post('/delete_movie', [App\Http\Controllers\MovieController::class, 'destroy'])->name('delete_movie');
    Route::post('/delete_showtime', [App\Http\Controllers\ShowtimeController::class, 'destroy'])->name('delete_showtime');
});

Auth::routes();

Route::get('/{date?}', [App\Http\Controllers\CinemaCatalogController::class, 'index'])->name('/');
Route::get('hall/{showtimeId}/{selectedDate}', [App\Http\Controllers\HallSeatSelectionController::class, 'getHallConfiguration'])->name('hall');
Route::get('payment/{hallConfigIdData}/{sum}/{showtimeId}/{selectedDate}', [App\Http\Controllers\PaymentController::class, 'indexPayment'])->name('payment');
Route::get('ticket/{showtimeId}/{hallConfigIdData}/{selectedDate}', [App\Http\Controllers\TicketController::class, 'store'])->name('ticket');