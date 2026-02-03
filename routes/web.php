<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\GuestController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Rooms
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::post('/rooms/{room}/check-availability', [RoomController::class, 'checkAvailability'])->name('rooms.checkAvailability');
Route::get('/rooms/{room}/calendar', [RoomController::class, 'getCalendarEvents'])->name('rooms.calendar');

// Booking - Guest accessible
Route::get('/booking/confirmation/{bookingCode}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
Route::get('/my-booking', [BookingController::class, 'search'])->name('booking.search');
Route::post('/my-booking', [BookingController::class, 'find'])->name('booking.find');

// Booking - Auth required
Route::middleware('auth')->group(function () {
    Route::get('/booking/{room}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Room Types
    Route::resource('room-types', RoomTypeController::class)->except(['show']);
    
    // Rooms
    Route::delete('/rooms/{room}/image/{index}', [AdminRoomController::class, 'deleteImage'])->name('rooms.deleteImage');
    Route::resource('rooms', AdminRoomController::class);
    
    // Bookings
    Route::get('/bookings/calendar', [AdminBookingController::class, 'calendar'])->name('bookings.calendar');
    Route::get('/bookings/calendar/events', [AdminBookingController::class, 'calendarEvents'])->name('bookings.calendarEvents');
    Route::post('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/check-in', [AdminBookingController::class, 'checkIn'])->name('bookings.checkIn');
    Route::post('/bookings/{booking}/check-out', [AdminBookingController::class, 'checkOut'])->name('bookings.checkOut');
    Route::post('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::resource('bookings', AdminBookingController::class);
    
    // Guests
    Route::resource('guests', GuestController::class)->except(['create', 'store']);
});

// Auth routes - using Laravel Breeze or simple auth
require __DIR__.'/auth.php';
