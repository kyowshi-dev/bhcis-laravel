<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConsultationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- PROTECTED ROUTES (Only for logged-in users) ---
Route::middleware('auth')->group(function () 
{

    // --- 1. SEARCH API (Keep these at the top) ---
    Route::get('/search/patients', [SearchController::class, 'patients'])->name('search.patients');
    Route::get('/search/diagnoses', [SearchController::class, 'diagnoses'])->name('search.diagnoses');
    Route::get('/search/medicines', [SearchController::class, 'medicines'])->name('search.medicines');

    // --- 2. PATIENT MANAGEMENT ---

    // Homepage & List (Uses Controller to load data) 
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');

    // Create Patient (MUST be before the {id} wildcard)
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

    // Show Profile (Wildcard - catches IDs like 1, 2, 100)
    Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');

    // --- 3. CONSULTATION MODULE ---
    // Triage (Admission)
    Route::get('/patients/{id}/consultations/create', [ConsultationController::class, 'create'])->name('consultations.create');
    Route::post('/patients/{id}/consultations', [ConsultationController::class, 'store'])->name('consultations.store');

    // Doctor's Workspace
    Route::get('/consultations/{id}', [ConsultationController::class, 'show'])->name('consultations.show');
    Route::post('/consultations/{id}/diagnosis', [ConsultationController::class, 'addDiagnosis'])->name('consultations.diagnosis');
    Route::post('/consultations/{id}/prescription', [ConsultationController::class, 'addPrescription'])->name('consultations.prescription');
});