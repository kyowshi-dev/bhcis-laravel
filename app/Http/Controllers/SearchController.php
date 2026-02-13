<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Search for Patients (by Name)
     */
    public function patients(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        // Search by Last Name OR First Name
        // We limit to 10 results for speed
        $patients = DB::table('patients')
            ->where('last_name', 'LIKE', "{$query}%")
            ->orWhere('first_name', 'LIKE', "{$query}%")
            ->select('id', 'first_name', 'last_name', 'sex', 'date_of_birth')
            ->limit(10)
            ->get();

        // Format the results for the frontend
        $results = $patients->map(function ($patient) {
            return [
                'id' => $patient->id,
                'text' => $patient->last_name . ', ' . $patient->first_name, // What shows in the dropdown
                'subtext' => $patient->sex . ' | ' . $patient->date_of_birth, // Extra info
            ];
        });

        return response()->json($results);
    }

    /**
     * Search for Diagnosis (ICD-10 or Name)
     */
    public function diagnoses(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        $diagnoses = DB::table('diagnosis_lookup')
            ->where('diagnosis_name', 'LIKE', "%{$query}%")
            ->orWhere('diagnosis_code', 'LIKE', "{$query}%")
            ->select('id', 'diagnosis_code', 'diagnosis_name')
            ->limit(15)
            ->get();

        $results = $diagnoses->map(function ($d) {
            return [
                'id' => $d->id,
                'text' => $d->diagnosis_code . ' - ' . $d->diagnosis_name,
            ];
        });

        return response()->json($results);
    }

    /**
     * Search for Medicines (Generic Name)
     */
    public function medicines(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        $medicines = DB::table('medicines_lookup')
            ->where('medicine_name', 'LIKE', "%{$query}%")
            ->select('id', 'medicine_name')
            ->limit(15)
            ->get();

        $results = $medicines->map(function ($m) {
            return [
                'id' => $m->id,
                'text' => $m->medicine_name,
            ];
        });

        return response()->json($results);
    }
}
