<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentManagementController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorManagementController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientManagementController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('loginPage');
Route::get('/registration', [RegistrationController::class, 'registrationPage'])->name('registrationPage');
Route::post('/register', [RegistrationController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin-only routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::prefix('/doctor-management')->group(function () {
        Route::get('doctors-list', [DoctorManagementController::class, 'list'])->name('doctor.list');
        Route::resource('doctor', DoctorManagementController::class);
        Route::get('doctor-availablity/{id}', [DoctorManagementController::class, 'doctorAvailablity'])->name('doctor.availability');
        Route::get('doctor-availablity-list', [DoctorManagementController::class, 'doctorAvailablityList'])->name('doctor.availability.list');
        Route::get('doctor-availablity-create/{id}', [DoctorManagementController::class, 'doctorAvailablityCreatePage'])->name('doctor.availability.create');
        Route::delete('doctor-availablity-delete/{id}', [DoctorManagementController::class, 'doctorAvailabilityDelete'])->name('doctor.availability.delete');
        Route::post('doctor-availablity-store', [DoctorManagementController::class, 'doctorAvailablityStore'])->name('doctor.availability.store');
    });
});

// Doctor-only routes
Route::middleware(['auth', 'role:Doctor,Admin'])->group(function () {
    Route::get('/doctor-dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/patients', [PatientManagementController::class, 'index'])->name('my_patients.index');
    Route::get('/patients-list', [PatientManagementController::class, 'list'])->name('my_patients.list');
    Route::get('/update-status/{id}', [PatientManagementController::class, 'actionsPage'])->name('patient.updateActionPage');
    Route::post('/update-status-action', [PatientManagementController::class, 'updateStatus'])->name('patient.update_status');
});

// Patient-only routes
Route::middleware(['auth', 'role:Patient,Admin'])->group(function () {
    Route::get('/patient-dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/appointments', [AppointmentManagementController::class, 'index'])->name('my_appointments.index');
    Route::get('/appointments-list', [AppointmentManagementController::class, 'list'])->name('my_appointments.list');
    Route::get('/create-appointment', [AppointmentManagementController::class, 'create'])->name('appointment.create');
    Route::post('/store-appointment', [AppointmentManagementController::class, 'store'])->name('appointment.store');
    Route::get('/getDoctorAvailabilityDates', [AppointmentManagementController::class, 'getDoctorAvailabilityDates'])->name('getDoctorAvailabilityDates');
    Route::get('/getDoctorAvailabilityTimeSlots', [AppointmentManagementController::class, 'getDoctorAvailabilityTimeSlots'])->name('getDoctorAvailabilityTimeSlots');
    Route::post('/update-status', [AppointmentManagementController::class, 'updateStatus'])->name('appointment.update_status');
});
