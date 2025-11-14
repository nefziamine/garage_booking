<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GarageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Page de choix du type d'inscription
Route::get('/register', function () {
    return view('auth.register-choice');
})->name('register.choice');

// Inscription Client
Route::get('/register/client', function () {
    return view('auth.register-client');
})->name('register.client');
Route::post('/register/client', [RegisterController::class, 'registerClient']);

// Inscription Garage
Route::get('/register/garage', function () {
    return view('auth.register-garage');
})->name('register.garage');
Route::post('/register/garage', [RegisterController::class, 'registerGarage']);

// Profile Routes (protégées par auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Dashboard route (redirige automatiquement vers le profil)
Route::middleware('auth')->get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// Garage Routes
Route::get('/garages', [GarageController::class, 'index'])->name('garages.index');
Route::get('/garages/search', [GarageController::class, 'search'])->name('garages.search');
Route::get('/garages/{garage}', [GarageController::class, 'show'])->name('garages.show');

// Booking Routes (protégées par auth)
Route::middleware('auth')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/received', [BookingController::class, 'received'])->name('bookings.received');
    Route::get('/bookings/create/{garage}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/{garage}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/complete', [BookingController::class, 'complete'])->name('bookings.complete');
});

// Payment Routes (protégées par auth)
Route::middleware('auth')->group(function () {
    Route::get('/payments/{booking}/method', [\App\Http\Controllers\PaymentController::class, 'selectPaymentMethod'])->name('payments.method');
    Route::get('/payments/{booking}/checkout', [\App\Http\Controllers\PaymentController::class, 'createPaymentIntent'])->name('payments.checkout');
    Route::post('/payments/{booking}/process', [\App\Http\Controllers\PaymentController::class, 'processPayment'])->name('payments.process');
    Route::get('/payments/{booking}/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payments.success');
    Route::get('/payments/{booking}/cancel', [\App\Http\Controllers\PaymentController::class, 'cancel'])->name('payments.cancel');
    Route::get('/prepare-booking', function () {
        return redirect()->route('welcome')->with('error', 'Veuillez créer une réservation depuis la page du garage.');
    })->name('prepare_booking');
    Route::post('/prepare-booking', [BookingController::class, 'preparePayment'])->name('bookings.prepare_payment');
    Route::get('/payments/multi-checkout', [\App\Http\Controllers\PaymentController::class, 'createMultiPaymentIntent'])->name('payments.multi_checkout');
    Route::post('/payments/multi-process', [\App\Http\Controllers\PaymentController::class, 'processMultiPayment'])->name('payments.multi_process');
    Route::get('/payments/multi-success', [\App\Http\Controllers\PaymentController::class, 'multiSuccess'])->name('payments.multi_success');
});

// Route pour voir les exemples de boutons
Route::get('/examples/buttons', function () {
    return view('examples.buttons');
})->name('examples.buttons');

// Static Pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Test route to check database users
Route::get('/test-users', function () {
    $users = \App\Models\User::all();
    return view('test-users', compact('users'));
})->name('test.users');

