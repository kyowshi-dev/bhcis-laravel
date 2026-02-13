<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    // 1. Show the Admission Form (Triage)
    public function create($patientId)
    {
        $patient = DB::table('patients')->find($patientId);
        
        if (!$patient) {
            abort(404, 'Patient not found');
        }

        return view('consultations.create', compact('patient'));
    }

    // 2. Save the Data (Triage Save)
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'nature_of_visit' => 'required',
            'bp_systolic' => 'nullable|numeric',
            'bp_diastolic' => 'nullable|numeric',
            'temperature' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request, $patientId) {
            
            // A. Create Consultation Record
            $consultationId = DB::table('consultations')->insertGetId([
                'patient_id' => $patientId,
                'worker_id' => 1, // Hardcoded for now
                'status' => 'pending_doctor',
                'nature_of_visit' => $request->nature_of_visit,
                'chief_complaint_id' => null, // Simplified for now
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // B. Create Vitals Record
            DB::table('vitals')->insert([
                'consultation_id' => $consultationId,
                'bp_systolic' => $request->bp_systolic,
                'bp_diastolic' => $request->bp_diastolic,
                'weight_kg' => $request->weight,
                'height_cm' => $request->height,
                'temperature_c' => $request->temperature,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('patients.show', $patientId)
                         ->with('success', 'Consultation started successfully!');
    }

    // 3. Show the Doctor's Workspace (View Consultation)
	public function show($id)
    	{
        	$consultation = DB::table('consultations')->find($id);
        
        	if (!$consultation) {
            		abort(404, 'Consultation not found');
        		}

        $patient = DB::table('patients')->find($consultation->patient_id);
        $vitals = DB::table('vitals')->where('consultation_id', $id)->first();
        
        // Fetch Diagnoses
        $diagnoses = DB::table('diagnosis_records')
            ->join('diagnosis_lookup', 'diagnosis_records.diagnosis_id', '=', 'diagnosis_lookup.id')
            ->where('consultation_id', $id)
            ->select('diagnosis_records.*', 'diagnosis_lookup.diagnosis_name', 'diagnosis_lookup.diagnosis_code')
            ->get();

        // Fetch Prescriptions (NEW)
        // Fetch Prescriptions (Fixed)
        $prescriptions = DB::table('prescriptions')
            ->join('medicines_lookup', 'prescriptions.medicine_id', '=', 'medicines_lookup.id')
            ->where('prescriptions.consultation_id', $id) // <--- Added 'prescriptions.' to be specific
            ->select(
                'prescriptions.*', 
                'medicines_lookup.medicine_name' 
                // Removed 'medicines_lookup.category' to avoid crashes
            )
            ->get();

        return view('consultations.show', compact('consultation', 'patient', 'vitals', 'diagnoses', 'prescriptions'));
    }

    // 4. Save a Diagnosis (Doctor's Action)
    public function addDiagnosis(Request $request, $id)
    {
        $request->validate([
            'diagnosis_id' => 'required|exists:diagnosis_lookup,id',
            'remarks' => 'nullable|string'
        ]);

        // Save the diagnosis
        DB::table('diagnosis_records')->insert([
            'consultation_id' => $id,
            'diagnosis_id' => $request->diagnosis_id,
            'remarks' => $request->remarks,
            'diagnosed_by' => 1, // Hardcoded Doctor ID
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update status to completed
        DB::table('consultations')->where('id', $id)->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Diagnosis added successfully!');
    }

	// 5. Save a Prescription
    public function addPrescription(Request $request, $id)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines_lookup,id',
            'quantity' => 'required|integer|min:1',
            'dosage' => 'required|string', // e.g., "1 tab 3x a day"
            'duration' => 'nullable|string', // e.g., "7 days"
        ]);

        DB::table('prescriptions')->insert([
            'consultation_id' => $id,
            'medicine_id' => $request->medicine_id,
            'quantity' => $request->quantity,
            'dosage' => $request->dosage,
            'duration' => $request->duration,
            'prescribed_by' => 1, // Hardcoded Doctor ID
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Medicine added successfully!');
    }
}
