@extends('layouts.app')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Dashboard</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-6">
        <div class="bg-white p-4 lg:p-6 rounded-xl lg:rounded-lg shadow-md border-l-4 border-blue-500">
            <h2 class="text-gray-500 text-xs lg:text-sm font-semibold mb-1 lg:mb-2">TOTAL PATIENTS</h2>
            <p class="text-2xl lg:text-3xl font-bold text-gray-800">{{ $totalPatients }}</p>
        </div>

        <div class="bg-white p-4 lg:p-6 rounded-xl lg:rounded-lg shadow-md border-l-4 border-yellow-500">
            <h2 class="text-gray-500 text-xs lg:text-sm font-semibold mb-1 lg:mb-2">PENDING APPOINTMENTS</h2>
            <p class="text-2xl lg:text-3xl font-bold text-gray-800">{{ $pendingAppointments }}</p>
        </div>

        <div class="bg-white p-4 lg:p-6 rounded-xl lg:rounded-lg shadow-md border-l-4 border-green-500 sm:col-span-2 lg:col-span-1">
            <h2 class="text-gray-500 text-xs lg:text-sm font-semibold mb-1 lg:mb-2">HEALTH WORKERS</h2>
            <p class="text-2xl lg:text-3xl font-bold text-gray-800">{{ $doctorsOnDuty }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl lg:rounded-lg shadow-md p-4 lg:p-6">
        <h3 class="text-lg lg:text-xl font-bold text-gray-800 mb-3 lg:mb-4">Recent Activity</h3>
        <ul class="divide-y divide-gray-200 space-y-0">
            @forelse($recentActivity as $activity)
                <li class="py-2 lg:py-3 text-sm lg:text-base text-gray-600 hover:bg-gray-50">
                    {{ $activity }}
                </li>
            @empty
                <li class="py-4 text-gray-500 text-sm">No recent activity.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
