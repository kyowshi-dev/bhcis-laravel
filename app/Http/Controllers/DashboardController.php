<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Patient; // Uncomment this later when you have a Patient model

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Fetch real data (Example logic)
        // $totalPatients = Patient::count();
        // $newPatientsToday = Patient::whereDate('created_at', today())->count();

        // 2. For now, let's use dummy data to test the design
        $totalPatients = 120;
        $pendingAppointments = 5;
        $recentActivity = [
            'Patient John Doe added',
            'Vaccination record updated',
            'Dr. Smith logged in'
        ];

        // 3. Send this data to the view
        return view('dashboard', compact('totalPatients', 'pendingAppointments', 'recentActivity'));
    }
}