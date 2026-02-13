@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">New Consultation</h1>
            <p class="text-gray-500">Admitting Patient: <span class="font-bold text-green-700">{{ $patient->last_name }}, {{ $patient->first_name }}</span></p>
        </div>
        <a href="{{ route('patients.show', $patient->id) }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
    </div>

    <form action="{{ route('consultations.store', $patient->id) }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 h-fit">
                <h3 class="font-bold text-lg mb-4 text-gray-700">1. Visit Details</h3>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nature of Visit</label>
                    <select name="nature_of_visit" class="w-full p-2 border rounded focus:ring-green-500 focus:border-green-500">
                        <option value="Checkup">General Checkup</option>
                        <option value="Prenatal">Prenatal Checkup</option>
                        <option value="Immunization">Immunization</option>
                        <option value="Emergency">Emergency / Injury</option>
                        <option value="Follow-up">Follow-up Visit</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Chief Complaint (Optional)</label>
                    <textarea name="chief_complaint" rows="3" class="w-full p-2 border rounded focus:ring-green-500 focus:border-green-500" placeholder="Ex: Fever for 3 days, cough..."></textarea>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-gray-700">2. Vital Signs</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Blood Pressure (mmHg)</label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="bp_systolic" placeholder="120" class="w-full p-2 border rounded text-center">
                            <span class="text-gray-400">/</span>
                            <input type="number" name="bp_diastolic" placeholder="80" class="w-full p-2 border rounded text-center">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Temperature (°C)</label>
                        <input type="number" step="0.1" name="temperature" placeholder="36.5" class="w-full p-2 border rounded text-center" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                        <input type="number" step="0.1" name="weight" placeholder="kg" class="w-full p-2 border rounded text-center">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Height (cm)</label>
                        <input type="number" step="0.1" name="height" placeholder="cm" class="w-full p-2 border rounded text-center">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition hover:-translate-y-0.5">
                Save & Proceed to Doctor
            </button>
        </div>
    </form>
</div>
@endsection
