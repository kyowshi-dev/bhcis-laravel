@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
            <h2 class="text-gray-500 text-sm font-semibold">TOTAL PATIENTS</h2>
            <p class="text-3xl font-bold text-gray-800">{{ $totalPatients }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
            <h2 class="text-gray-500 text-sm font-semibold">PENDING APPOINTMENTS</h2>
            <p class="text-3xl font-bold text-gray-800">{{ $pendingAppointments }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
            <h2 class="text-gray-500 text-sm font-semibold">DOCTORS ON DUTY</h2>
            <p class="text-3xl font-bold text-gray-800">3</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Activity</h3>
        <ul class="divide-y divide-gray-200">
            @foreach($recentActivity as $activity)
                <li class="py-3 text-gray-600 hover:bg-gray-50">
                    {{ $activity }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection