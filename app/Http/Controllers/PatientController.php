<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientController extends Controller
{
    // 1. List all patients
    public function index()
    {
        $patients = DB::table('patients')
            ->join('households', 'patients.household_id', '=', 'households.id')
            ->select('patients.*', 'households.family_name_head', 'households.zone_id')
            ->orderByDesc('patients.created_at')
            ->get();

        return view('patients.index', compact('patients'));
    }

    // 2. Show the Registration Form
    public function create()
    {
        // We need households for the dropdown
        $households = DB::table('households')
            ->select('id', 'family_name_head', 'zone_id')
            ->orderBy('family_name_head')
            ->get();

        return view('patients.create', compact('households'));
    }

    // 3. Save the New Patient
    public function store(Request $request)
    {
        // --- 1. ENHANCED VALIDATION ---
        $validated = $request->validate([
            'household_id' => 'required|exists:households,id', // Still required for now
            
            // Name: Only letters, spaces, dots, and dashes. No numbers.
            'first_name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z\s\-\.]+$/'],
            'last_name'  => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z\s\-\.]+$/'],
            'middle_name'=> ['nullable', 'string', 'max:50', 'regex:/^[a-zA-Z\s\-\.]+$/'],
            
            'sex' => 'required|in:Male,Female',
            
            // Birthdate: Must be a valid date and NOT in the future
            'date_of_birth' => 'required|date|before:today',
            
            'civil_status' => 'required|in:Single,Married,Widowed,Separated,Common Law',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'educational_attainment' => 'nullable|string',
            'employment_status' => 'nullable|string|max:100',
        ], [
            // Custom Error Messages
            'first_name.regex' => 'First name cannot contain numbers or special symbols.',
            'date_of_birth.before' => 'Birth date cannot be in the future.',
            'household_id.required' => 'You must assign a household. If none exists, register the household first.',
        ]);

        // --- 2. DUPLICATE CHECK ---
        // Prevents double-entry of the same person
        $exists = DB::table('patients')
            ->where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->where('date_of_birth', $request->date_of_birth)
            ->exists();

        if ($exists) {
            // Returns the user to the form with their input intact
            return back()->withInput()->withErrors(['first_name' => 'This patient is already registered in the system!']);
        }

        // --- 3. INSERT DATA (Sanitized) ---
        DB::table('patients')->insert([
            'household_id' => $request->household_id,
            // Auto-Capitalize Names
            'first_name' => ucwords(strtolower($request->first_name)),
            'last_name'  => ucwords(strtolower($request->last_name)),
            'middle_name'=> $request->middle_name ? ucwords(strtolower($request->middle_name)) : null,
            
            'suffix' => $request->suffix,
            'sex' => $request->sex,
            'date_of_birth' => $request->date_of_birth,
            'birth_place' => $request->birth_place,
            'blood_type' => $request->blood_type,
            'civil_status' => $request->civil_status,
            'educational_attainment' => $request->educational_attainment,
            'employment_status' => $request->employment_status,
            
            'has_4ps' => $request->has('has_4ps') ? 1 : 0,
            'has_nhts' => $request->has('has_nhts') ? 1 : 0,
            
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient registered successfully!');
    }

    // 4. View Single Patient Profile
    public function show($id)
    {
        // 1. Find the patient
        $patient = DB::table('patients')
            ->join('households', 'patients.household_id', '=', 'households.id')
            ->where('patients.id', $id)
            ->select('patients.*', 'households.family_name_head', 'households.zone_id')
            ->first();

        if (!$patient) {
            abort(404, 'Patient not found');
        }

        // 2. Calculate Age
        $patient->age = \Carbon\Carbon::parse($patient->date_of_birth)->age;

        // 3. Load Consultations (History)
        $history = DB::table('consultations')
            ->leftJoin('users', 'consultations.worker_id', '=', 'users.id')
            ->where('patient_id', $id)
            ->select(
                'consultations.*',
                'users.username as worker_name',  // <--- FIXED: Uses 'username'
                'consultations.nature_of_visit as complaint_name' // Fallback for complaint
            )
            ->orderByDesc('consultations.created_at')
            ->get();

        return view('patients.show', compact('patient', 'history'));
    }
}