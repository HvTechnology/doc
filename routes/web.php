<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentDestroyController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BookingEmployeeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\OtpController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Carbon::setTestNow(now()->addDay()->setTimeFromTimeString('09:00:00'));

Route::get('/bookings', BookingController::class)->name('bookings');
Route::get('/bookings/{employee:slug}', BookingEmployeeController::class)->name('bookings.employee');
Route::get('/checkout/{employee:slug}/{service:slug}', CheckoutController::class)->name('checkout');
Route::get('/{id}/checkout/dr.Tomaipitinca/visita_medica/', [CheckoutController::class, 'newapp'])->name('dashboard.newapp');
Route::get('/slots/{employee:slug}/{service:slug}', SlotController::class)->name('slots');

Route::post('/appointments', AppointmentController::class)->name('appointments');

Route::get('/confirmation/{appointment:uuid}', ConfirmationController::class)->name('confirmation');
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
});

Route::post('/logout', [UsersController::class, 'logout'])->name('logout');

Route::get('/dashboard/schedule', [UsersController::class, 'edit'])->name('Scheduleedit')->middleware('auth');
Route::get('/dashboard', [UsersController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/pazienti', [PatientController::class, 'pazienti'])->name('pazienti')->middleware('auth');
Route::post('/pazienti/store', [PatientController::class, 'store'])->name('patients.store')->middleware('auth');
Route::get('/patients/{id}', [PatientController::class, 'show'])->middleware('auth');
Route::put('/patients/{id}', [PatientController::class, 'update'])->middleware('auth');
Route::post('/users/authenticate', [UsersController::class, 'authenticate']);
Route::post('/check-codice-fiscale', [PatientController::class, 'checkCodiceFiscale'])->name('check_codice_fiscale');
Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('send_otp');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('verify_otp');

// routes/web.php
;
Route::put('/schedules/{id}', [SchedulesController::class, 'update'])->name('schedules.update');

Route::get('/vacation', [SchedulesController::class, 'vacation'])->name('vacation');
Route::post('/employee-times', [SchedulesController::class, 'store'])->name('employee_times.store');
Route::delete('/employee-times/{id}', [SchedulesController::class, 'destroy'])->name('employee_times.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/appointments/calendar', [AppointmentController::class, 'calendar'])->name('appointments.calendar');
    Route::get('/appointments/events', [AppointmentController::class, 'getEvents'])->name('appointments.events');
    
Route::delete('/appointments/{appointment}', AppointmentDestroyController::class)->name('appointments.destroy');

Route::get('/patients', [PatientController::class, 'search'])->name('patients.search');
Route::get('/patients/{id}/view', [PatientController::class, 'view'])->name('patients.view');


});



