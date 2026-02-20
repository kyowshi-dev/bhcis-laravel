<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('consultations')
            ->join('patients', 'consultations.patient_id', '=', 'patients.id')
            ->join('health_workers', 'consultations.worker_id', '=', 'health_workers.id')
            ->select(
                'consultations.id',
                'consultations.patient_id',
                'consultations.status',
                'consultations.created_at',
                'patients.first_name as patient_first_name',
                'patients.last_name as patient_last_name',
                'health_workers.first_name as worker_first_name',
                'health_workers.last_name as worker_last_name'
            )
            ->orderByDesc('consultations.created_at');

        if ($request->filled('query')) {
            $q = $request->input('query');
            $query->where(function ($qb) use ($q) {
                $qb->where('patients.first_name', 'like', '%'.$q.'%')
                    ->orWhere('patients.last_name', 'like', '%'.$q.'%')
                    ->orWhereRaw('CONCAT(patients.last_name, ", ", patients.first_name) LIKE ?', ['%'.$q.'%']);
                if (is_numeric($q)) {
                    $qb->orWhere('patients.id', (int) $q);
                }
                if (preg_match('/^PT\s*(\d+)$/i', trim($q), $m)) {
                    $qb->orWhere('patients.id', (int) $m[1]);
                }
                $qb->orWhereExists(function ($ex) use ($q) {
                    $ex->select(DB::raw(1))
                        ->from('diagnosis_records')
                        ->join('diagnosis_lookup', 'diagnosis_records.diagnosis_id', '=', 'diagnosis_lookup.id')
                        ->whereColumn('diagnosis_records.consultation_id', 'consultations.id')
                        ->where('diagnosis_lookup.diagnosis_name', 'like', '%'.$q.'%');
                });
            });
        }

        if ($request->filled('date_from')) {
            $parsed = Carbon::createFromFormat('d/m/Y', trim($request->input('date_from')));
            if ($parsed !== false) {
                $query->where('consultations.created_at', '>=', $parsed->copy()->startOfDay());
            }
        }
        if ($request->filled('date_to')) {
            $parsed = Carbon::createFromFormat('d/m/Y', trim($request->input('date_to')));
            if ($parsed !== false) {
                $query->where('consultations.created_at', '<=', $parsed->copy()->endOfDay());
            }
        }

        $consultations = $query->get();

        $consultationIds = $consultations->pluck('id')->toArray();

        $diagnosisByConsultation = [];
        $treatmentByConsultation = [];
        if (! empty($consultationIds)) {
            $diagnosisRows = DB::table('diagnosis_records')
                ->join('diagnosis_lookup', 'diagnosis_records.diagnosis_id', '=', 'diagnosis_lookup.id')
                ->whereIn('diagnosis_records.consultation_id', $consultationIds)
                ->select('diagnosis_records.consultation_id', 'diagnosis_lookup.diagnosis_name', 'diagnosis_records.remarks')
                ->orderBy('diagnosis_records.id')
                ->get();
            foreach ($diagnosisRows as $row) {
                $diagnosisByConsultation[$row->consultation_id][] = trim($row->diagnosis_name.($row->remarks ? ' - '.$row->remarks : ''));
            }

            $prescriptionRows = DB::table('prescriptions')
                ->join('medicines_lookup', 'prescriptions.medicine_id', '=', 'medicines_lookup.id')
                ->whereIn('prescriptions.consultation_id', $consultationIds)
                ->select('prescriptions.consultation_id', 'medicines_lookup.medicine_name', 'prescriptions.dosage', 'prescriptions.duration')
                ->get();
            foreach ($prescriptionRows as $row) {
                $treatmentByConsultation[$row->consultation_id][] = $row->medicine_name.($row->dosage ? ' '.$row->dosage : '').($row->duration ? ', '.$row->duration : '');
            }
        }

        $totalConsultations = DB::table('consultations')->count();
        $thisWeekCount = DB::table('consultations')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $completedCount = DB::table('consultations')->where('status', 'completed')->count();

        return view('consultations.index', [
            'consultations' => $consultations,
            'diagnosisByConsultation' => $diagnosisByConsultation,
            'treatmentByConsultation' => $treatmentByConsultation,
            'totalConsultations' => $totalConsultations,
            'thisWeekCount' => $thisWeekCount,
            'completedCount' => $completedCount,
        ]);
    }

    // 1. Show the Admission Form (Triage)
    public function create($patientId)
    {
        $patient = DB::table('patients')->find($patientId);

        if (! $patient) {
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
                'chief_complaint_id' => null,
                'complaint_text' => $request->chief_complaint,
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

        if (! $consultation) {
            abort(404, 'Consultation not found');
        }

        $patient = DB::table('patients')->find($consultation->patient_id);

        // 1. Fetch the Consultation Data
        $vitals = DB::table('vitals')->where('consultation_id', $id)->first();

        // 2. Fetch Existing Records (History)
        $existingDiagnoses = DB::table('diagnosis_records')
            ->join('diagnosis_lookup', 'diagnosis_records.diagnosis_id', '=', 'diagnosis_lookup.id')
            ->where('consultation_id', $id)
            ->select('diagnosis_records.*', 'diagnosis_lookup.diagnosis_name', 'diagnosis_lookup.diagnosis_code')
            ->get();

        $existingPrescriptions = DB::table('prescriptions')
            ->join('medicines_lookup', 'prescriptions.medicine_id', '=', 'medicines_lookup.id')
            ->where('prescriptions.consultation_id', $id)
            ->select('prescriptions.*', 'medicines_lookup.medicine_name')
            ->get();

        // 3. NEW: Fetch Dropdown Options (The "Menu" for the Doctor)
        $diagnosisOptions = DB::table('diagnosis_lookup')->orderBy('diagnosis_name')->get();
        $medicineOptions = DB::table('medicines_lookup')->orderBy('medicine_name')->get();

        return view('consultations.show', [
            'consultation' => $consultation,
            'patient' => $patient,
            'vitals' => $vitals,
            'diagnoses' => $existingDiagnoses,
            'prescriptions' => $existingPrescriptions,
            'diagnosisOptions' => $diagnosisOptions,
            'medicineOptions' => $medicineOptions,
        ]);
    }

    // 4. Save a Diagnosis (Doctor's Action)
    public function addDiagnosis(Request $request, $id)
    {
        $request->validate([
            'diagnosis_id' => 'required|exists:diagnosis_lookup,id',
            'remarks' => 'nullable|string',
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
