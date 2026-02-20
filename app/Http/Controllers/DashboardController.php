<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = DB::table('patients')->count();

        $pendingAppointments = DB::table('consultations')
            ->whereIn('status', ['triage', 'pending_doctor'])
            ->count();

        $doctorsOnDuty = DB::table('health_workers')->count();

        $recentActivity = DB::table('audit_logs')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(function ($log) {
                $time = Carbon::parse($log->created_at)->format('M d, Y H:i');

                return "{$time} – {$log->action} on {$log->table_name} #{$log->record_id}";
            })
            ->all();

        return view('dashboard', [
            'totalPatients' => $totalPatients,
            'pendingAppointments' => $pendingAppointments,
            'doctorsOnDuty' => $doctorsOnDuty,
            'recentActivity' => $recentActivity,
        ]);
    }
}
