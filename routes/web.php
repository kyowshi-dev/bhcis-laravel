<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConsultationController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\SearchController;

// Search Endpoints (API)
Route::get('/search/patients', [SearchController::class, 'patients'])->name('search.patients');
Route::get('/search/diagnoses', [SearchController::class, 'diagnoses'])->name('search.diagnoses');
Route::get('/search/medicines', [SearchController::class, 'medicines'])->name('search.medicines');
Route::view('/patients', 'patients.index');
Route::view('/', 'patients.index'); // Make it the homepage for now
Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');

// Consultation Routes
Route::get('/patients/{id}/consultations/create', [ConsultationController::class, 'create'])->name('consultations.create');
Route::post('/patients/{id}/consultations', [ConsultationController::class, 'store'])->name('consultations.store');

// Doctor's Workspace
Route::get('/consultations/{id}', [ConsultationController::class, 'show'])->name('consultations.show');
Route::post('/consultations/{id}/diagnosis', [ConsultationController::class, 'addDiagnosis'])->name('consultations.diagnosis');
Route::post('/consultations/{id}/prescription', [ConsultationController::class, 'addPrescription'])->name('consultations.prescription');
