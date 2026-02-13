<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientController extends Controller
{
    /**
     * Display the specified patient profile.
     */
    public function show($id)
    {
        // 1. Fetch Patient Details (with Household info)
        $patient = DB::table('patients')
            ->join('households', 'patients.household_id', '=', 'households.id')
            ->where('patients.id', $id)
            ->select('patients.*', 'households.family_name_head', 'households.zone_id', 'households.contact_number as guardian_contact')
            ->first();

        if (!$patient) {
            abort(404, 'Patient not found');
        }

        // Calculate Age
        $patient->age = Carbon::parse($patient->date_of_birth)->age;

        // 2. Fetch Consultation History
        $history = DB::table('consultations')
            ->leftJoin('health_workers', 'consultations.worker_id', '=', 'health_workers.id')
            ->leftJoin('complaint_lookup', 'consultations.chief_complaint_id', '=', 'complaint_lookup.id')
            ->where('patient_id', $id)
            ->select(
                'consultations.*', 
                'health_workers.first_name as worker_name',
                'complaint_lookup.complaint as complaint_name'
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patients.show', compact('patient', 'history'));
    }
}
