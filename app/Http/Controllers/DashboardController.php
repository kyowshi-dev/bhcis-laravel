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

        $onDutyStaff = DB::table('health_workers')
            ->select('first_name', 'last_name', 'position')
            ->orderBy('last_name')
            ->limit(5)
            ->get()
            ->map(function ($row) {
                $initials = mb_strtoupper(mb_substr($row->first_name, 0, 1).mb_substr($row->last_name, 0, 1));

                return [
                    'name' => trim($row->first_name.' '.$row->last_name),
                    'position' => (string) $row->position,
                    'initials' => $initials,
                ];
            })
            ->all();

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
            'onDutyStaff' => $onDutyStaff,
            'recentActivity' => $recentActivity,
        ]);
    }
}
