<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; // Added this import
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- PUBLIC ROUTES (No login required) ---
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- PROTECTED ROUTES (Only for logged-in users) ---
Route::middleware('auth')->group(function () {

    // 1. DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. SEARCH API (For AJAX/autocomplete)
    Route::get('/search/patients', [SearchController::class, 'patients'])->name('search.patients');
    Route::get('/search/diagnoses', [SearchController::class, 'diagnoses'])->name('search.diagnoses');
    Route::get('/search/medicines', [SearchController::class, 'medicines'])->name('search.medicines');

    // 3. PATIENT MANAGEMENT
    // List Patients
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');

    // Create Patient (Order matters: This must be BEFORE {id})
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

    // Show Patient Profile (Wildcard catches IDs like 1, 2, 100)
    Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');

    // 4. CONSULTATION MODULE
    // Triage / New Admission
    Route::get('/patients/{id}/consultations/create', [ConsultationController::class, 'create'])->name('consultations.create');
    Route::post('/patients/{id}/consultations', [ConsultationController::class, 'store'])->name('consultations.store');

    // Doctor's Workspace (View specific consultation)
    Route::get('/consultations/{id}', [ConsultationController::class, 'show'])->name('consultations.show');
    
    // Doctor Actions (Diagnosis & Rx)
    Route::post('/consultations/{id}/diagnosis', [ConsultationController::class, 'addDiagnosis'])->name('consultations.diagnosis');
    Route::post('/consultations/{id}/prescription', [ConsultationController::class, 'addPrescription'])->name('consultations.prescription');

}); // <--- End of Auth Group