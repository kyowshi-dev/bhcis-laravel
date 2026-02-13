@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="md:col-span-1 space-y-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="text-center mb-4">
                <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-3xl font-bold mx-auto">
                    {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                </div>
                <h2 class="text-xl font-bold mt-2">{{ $patient->last_name }}, {{ $patient->first_name }}</h2>
                <p class="text-gray-500 text-sm">ID: {{ str_pad($patient->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>

            <hr class="my-4">

            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Age / Sex:</span>
                    <span class="font-medium">{{ $patient->age }} y/o / {{ $patient->sex }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Birthdate:</span>
                    <span class="font-medium">{{ $patient->date_of_birth }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Blood Type:</span>
                    <span class="font-medium">{{ $patient->blood_type ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Zone:</span>
                    <span class="font-medium">Zone {{ $patient->zone_id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Civil Status:</span>
                    <span class="font-medium">{{ $patient->civil_status }}</span>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t">
                <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Programs</h4>
                <div class="flex gap-2">
                    @if($patient->has_4ps)
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">4Ps Member</span>
                    @endif
                    @if($patient->has_nhts)
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">NHTS</span>
                    @endif
                    @if(!$patient->has_4ps && !$patient->has_nhts)
                        <span class="text-gray-400 text-xs italic">No active programs</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="md:col-span-2">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Consultation History</h2>
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow-sm text-sm">
                <a href="{{ route('consultations.create', $patient->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow-sm text-sm">
    		+ New Consultation
		</a>
            </button>
        </div>

        @if($history->isEmpty())
            <div class="bg-white p-8 rounded-lg shadow-sm border border-dashed border-gray-300 text-center">
                <p class="text-gray-400 mb-2">No medical records found for this patient.</p>
                <p class="text-sm text-gray-500">Click "New Consultation" to create the first record.</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 font-medium border-b">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Complaint</th>
                            <th class="px-4 py-3">Attended By</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($history as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($record->created_at)->format('M d, Y') }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $record->complaint_name ?? 'General Checkup' }}</td>
                            <td class="px-4 py-3">{{ $record->worker_name ?? 'Staff' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs 
                                    {{ $record->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($record->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('consultations.show', $record->id) }}" class="text-green-600 hover:underline font-bold">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
