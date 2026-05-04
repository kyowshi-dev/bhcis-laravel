@extends('layouts.app')

@section('content')
<div class="space-y-3 lg:space-y-4">
    @if (session('success'))
        <div class="rounded-xl bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 px-4 lg:px-6 py-3 text-sm text-emerald-800 shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if ($errors->any())
        <div class="rounded-xl bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 px-4 lg:px-6 py-3 text-sm text-red-800 shadow-sm">
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-2">
        <div class="flex flex-wrap items-center gap-2 lg:gap-3">
            <a href="{{ route('patients.show', $patient->id) }}" class="inline-flex items-center gap-1 text-xs lg:text-sm font-medium text-sky-600 hover:text-sky-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to patient
            </a>
            <span class="text-gray-300 hidden sm:inline">|</span>
            <a href="{{ route('consultations.index') }}" class="inline-flex items-center gap-1 text-xs lg:text-sm font-medium text-sky-600 hover:text-sky-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                History
            </a>
        </div>
        <div class="flex items-center gap-3">
            @php
                $statusConfig = [
                    'pending_doctor' => ['icon' => '⏳', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'label' => 'Pending Review'],
                    'in_progress' => ['icon' => '🔄', 'bg' => 'bg-sky-100', 'text' => 'text-sky-700', 'label' => 'In Progress'],
                    'completed' => ['icon' => '<i class="fa-solid fa-check"></i>', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'label' => 'Completed'],
                    'referred' => ['icon' => '🏥', 'bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Referred'],
                ];
                $currentStatus = $statusConfig[$consultation->status] ?? $statusConfig['pending_doctor'];
            @endphp
            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }} shadow-sm">
                <span>{!! $currentStatus['icon'] !!}</span>
                {{ $currentStatus['label'] }}
            </span>
        </div>
    </div>

    <!-- Consultation Progress -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 lg:p-6 mt-4">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-lg lg:text-xl font-bold text-gray-800">Consultation #{{ $consultation->id }}</h1>
            <span class="text-xs lg:text-sm text-gray-500">{{ \Carbon\Carbon::parse($consultation->created_at)->format('M j, Y g:i A') }}</span>
        </div>

        @php
            $progressSteps = [
                ['key' => 'vitals', 'label' => 'Vitals', 'icon' => '<i class="fa-solid fa-heart-pulse"></i>', 'complete' => $vitals && ($vitals->bp_systolic || $vitals->temperature_c)],
                ['key' => 'diagnosis', 'label' => 'Diagnosis', 'icon' => '<i class="fa-solid fa-stethoscope"></i>', 'complete' => isset($diagnoses) && $diagnoses->count() > 0],
                ['key' => 'prescription', 'label' => 'Prescription', 'icon' => '<i class="fa-solid fa-prescription"></i>', 'complete' => isset($prescriptions) && $prescriptions->count() > 0],
                ['key' => 'complete', 'label' => 'Complete', 'icon' => '<i class="fa-solid fa-check"></i>', 'complete' => $consultation->status === 'completed'],
            ];
            $completedSteps = collect($progressSteps)->where('complete', true)->count();
            $progressPercentage = ($completedSteps / count($progressSteps)) * 100;
        @endphp

        <div class="space-y-3">
            <div class="flex items-center justify-between text-sm">
                <span class="font-medium text-gray-700">Consultation Progress</span>
                <span class="text-gray-500">{{ $completedSteps }}/{{ count($progressSteps) }} steps</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-sky-500 to-emerald-500 h-2 rounded-full transition-all duration-500 ease-out" style="width: {{ $progressPercentage }}%"></div>
            </div>
            <div class="flex justify-between">
                @foreach($progressSteps as $step)
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm {{ $step['complete'] ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-400' }} transition-colors">
                            {!! $step['icon'] !!}
                        </div>
                        <span class="text-xs text-gray-600 mt-1">{{ $step['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

<div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 mt-6 lg:mt-8">
    <div class="md:col-span-1 space-y-4 lg:space-y-6">
        <!-- Patient Information Card -->
        <div class="bg-gradient-to-br from-white to-gray-50 p-4 lg:p-6 rounded-xl lg:rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-lg lg:text-xl font-bold text-gray-800 truncate">{{ $patient->last_name }}, {{ $patient->first_name }}</h2>
                    <p class="text-xs lg:text-sm text-gray-500">Patient ID: PT{{ str_pad($patient->id, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 text-xs lg:text-sm">
                <div class="bg-white p-3 rounded-lg border border-gray-100">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-gray-500 font-medium">Sex</span>
                    </div>
                    <span class="font-semibold text-gray-800">{{ $patient->sex }}</span>
                </div>
                <div class="bg-white p-3 rounded-lg border border-gray-100">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-500 font-medium">Age</span>
                    </div>
                    <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} y/o</span>
                </div>
            </div>
        </div>

        @php
            $bp_systolic = $vitals->bp_systolic;
            $bp_diastolic = $vitals->bp_diastolic;
            $bp_status = 'unknown';
            $bp_label = 'Unavailable';
            $bp_valueClass = 'text-gray-700';
            $bp_badgeClass = 'bg-gray-100 text-gray-700';

            if ($bp_systolic !== null && $bp_diastolic !== null) {
                if ($bp_diastolic >= 110 || $bp_systolic >= 180) {
                    $bp_status = 'critical';
                    $bp_label = 'Critical';
                    $bp_valueClass = 'text-red-700';
                    $bp_badgeClass = 'bg-red-100 text-red-700';
                } elseif ($bp_diastolic >= 90 || $bp_systolic >= 140) {
                    $bp_status = 'abnormal';
                    $bp_label = 'Abnormal';
                    $bp_valueClass = 'text-amber-700';
                    $bp_badgeClass = 'bg-amber-100 text-amber-700';
                } else {
                    $bp_status = 'normal';
                    $bp_label = 'Normal';
                    $bp_valueClass = 'text-emerald-700';
                    $bp_badgeClass = 'bg-emerald-100 text-emerald-700';
                }
            }

            $temperature = $vitals->temperature_c;
            $temp_status = 'unknown';
            $temp_label = 'Unavailable';
            $temp_valueClass = 'text-gray-700';
            $temp_badgeClass = 'bg-gray-100 text-gray-700';

            if ($temperature !== null && $temperature !== '') {
                if ($temperature >= 39 || $temperature <= 35) {
                    $temp_status = 'critical';
                    $temp_label = 'Critical';
                    $temp_valueClass = 'text-red-700';
                    $temp_badgeClass = 'bg-red-100 text-red-700';
                } elseif ($temperature >= 37.5 || $temperature < 36) {
                    $temp_status = 'abnormal';
                    $temp_label = 'Abnormal';
                    $temp_valueClass = 'text-amber-700';
                    $temp_badgeClass = 'bg-amber-100 text-amber-700';
                } else {
                    $temp_status = 'normal';
                    $temp_label = 'Normal';
                    $temp_valueClass = 'text-emerald-700';
                    $temp_badgeClass = 'bg-emerald-100 text-emerald-700';
                }
            }
        @endphp

        <!-- Vital Signs Card -->
        <div class="bg-gradient-to-br from-sky-50 to-blue-50 p-4 lg:p-6 rounded-xl lg:rounded-2xl border border-sky-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 mb-4">
                <i class="fa-solid fa-heart-pulse text-xl text-sky-600"></i>
                <h3 class="font-bold text-sky-800 text-sm lg:text-base">Vital Signs</h3>
                @if($bp_status !== 'unknown' || $temp_status !== 'unknown')
                    <div class="ml-auto flex gap-1">
                        @if($bp_status === 'critical' || $temp_status === 'critical')
                            <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                        @elseif($bp_status === 'abnormal' || $temp_status === 'abnormal')
                            <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                        @else
                            <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                        @endif
                    </div>
                @endif
            </div>
            <div class="grid grid-cols-1 gap-4 text-xs lg:text-sm">
                <div class="bg-white p-3 rounded-lg border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sky-600 font-medium uppercase text-xs">BP</span>
                        <span class="text-red-500">*</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="font-bold text-lg {{ $bp_valueClass }}">{{ $bp_systolic ?? '—' }}/{{ $bp_diastolic ?? '—' }}</span>
                        @if($bp_status !== 'unknown')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $bp_badgeClass }}">{{ $bp_label }}</span>
                        @endif
                    </div>
                </div>
                <div class="bg-white p-3 rounded-lg border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sky-600 font-medium uppercase text-xs">Temp</span>
                        <span class="text-red-500">*</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="font-bold text-lg {{ $temp_valueClass }}">{{ $temperature !== null && $temperature !== '' ? $temperature.'°C' : '—' }}</span>
                        @if($temp_status !== 'unknown')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $temp_badgeClass }}">{{ $temp_label }}</span>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-white p-3 rounded-lg border border-gray-100">
                        <span class="text-sky-600 block font-medium uppercase text-xs mb-1">Weight</span>
                        <span class="font-bold text-gray-700">{{ $vitals->weight_kg ?? '—' }} kg</span>
                    </div>
                    <div class="bg-white p-3 rounded-lg border border-gray-100">
                        <span class="text-sky-600 block font-medium uppercase text-xs mb-1">Height</span>
                        <span class="font-bold text-gray-700">{{ $vitals->height_cm ?? '—' }} cm</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chief Complaint Card -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-4 lg:p-5 rounded-xl lg:rounded-2xl border border-amber-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 mb-3">
                <i class="fa-solid fa-comment-dots text-lg text-amber-600"></i>
                <h3 class="font-bold text-amber-800 text-sm lg:text-base">Chief Complaint</h3>
            </div>
            <div class="bg-white p-3 rounded-lg border border-amber-100">
                <p class="text-xs lg:text-sm text-gray-600 italic leading-relaxed">{{ $consultation->complaint_text ?? 'No complaint recorded' }}</p>
            </div>
        </div>
    </div>

    <div class="md:col-span-2 space-y-4 lg:space-y-6">
        <!-- Diagnosis Section -->
        <div class="bg-white p-4 lg:p-6 rounded-xl lg:rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 mb-4 lg:mb-6">
                <i class="fa-solid fa-stethoscope text-xl text-emerald-600"></i>
                <h3 class="font-bold text-base lg:text-lg text-gray-800">Medical Diagnosis</h3>
                @if(isset($diagnoses) && $diagnoses->count() > 0)
                    <span class="ml-auto bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs font-semibold">
                        {{ $diagnoses->count() }} diagnosis{{ $diagnoses->count() > 1 ? 'es' : '' }}
                    </span>
                @endif
            </div>

            @if(isset($diagnoses) && $diagnoses->count() > 0)
                <div class="mb-6 space-y-3">
                    @foreach($diagnoses as $d)
                        <div class="flex items-center justify-between bg-gradient-to-r from-emerald-50 to-green-50 p-3 lg:p-4 rounded-xl border border-emerald-100 hover:shadow-sm transition-shadow">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="font-bold text-emerald-800 text-sm">{{ $d->diagnosis_code }}</span>
                                    <p class="text-gray-700 text-sm">{{ $d->diagnosis_name }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded-full">Saved</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="border-t border-gray-100 pt-6">
                <form action="{{ route('consultations.diagnosis', $consultation->id) }}" method="POST" x-data="diagnosisSearch()" @set-diagnosis-query.window="setQuery($event.detail.query)" class="space-y-4">
                    @csrf
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search ICD-10 / Disease name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" x-model="query" @input.debounce.300ms="search()"
                               placeholder="e.g. Dengue, Hypertension..."
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm transition-all" autocomplete="off">
                        <input type="hidden" name="diagnosis_id" x-model="selectedId">
                        <div x-show="results.length > 0" class="absolute z-10 w-full bg-white mt-1 border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto" style="display: none;">
                            <ul>
                                <template x-for="item in results" :key="item.id">
                                    <li @click="select(item)" class="px-4 py-3 hover:bg-emerald-50 cursor-pointer border-b last:border-0 text-sm transition-colors">
                                        <span class="font-medium text-gray-800" x-text="item.text"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Remarks (optional)</label>
                        <textarea name="remarks" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition-all" placeholder="Additional notes..."></textarea>
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" :disabled="!selectedId" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Diagnosis
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Prescription Section -->
        <div class="bg-white p-4 lg:p-6 rounded-xl lg:rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 mb-4 lg:mb-6">
                <i class="fa-solid fa-prescription text-xl text-sky-600"></i>
                <h3 class="font-bold text-base lg:text-lg text-gray-800">Prescription (Rx)</h3>
                @if(isset($prescriptions) && $prescriptions->count() > 0)
                    <span class="ml-auto bg-sky-100 text-sky-700 px-2 py-1 rounded-full text-xs font-semibold">
                        {{ $prescriptions->count() }} prescription{{ $prescriptions->count() > 1 ? 's' : '' }}
                    </span>
                @endif
            </div>

            @if(isset($prescriptions) && $prescriptions->count() > 0)
                <div class="mb-6 overflow-hidden rounded-xl border border-gray-200 bg-gray-50/50">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-left">Medicine</th>
                                    <th class="px-4 py-3 font-semibold text-left">Dosage</th>
                                    <th class="px-4 py-3 font-semibold text-left hidden sm:table-cell">Duration</th>
                                    <th class="px-4 py-3 font-semibold text-center w-20">Qty</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($prescriptions as $rx)
                                    <tr class="hover:bg-sky-50/30 transition-colors">
                                        <td class="px-4 py-3 font-medium text-gray-800">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 bg-sky-100 rounded-full flex items-center justify-center text-xs">
                                                    <i class="fa-solid fa-prescription text-sky-600"></i>
                                                </div>
                                                {{ $rx->medicine_name }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">
                                            <div class="font-medium">{{ $rx->dosage }}</div>
                                            @if($rx->frequency)
                                                <div class="text-xs text-gray-500 sm:hidden">{{ $rx->frequency }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-700 hidden sm:table-cell">{{ $rx->duration ?? '—' }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full text-sm font-semibold">{{ $rx->quantity ?? '—' }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="border-t border-gray-100 pt-6">
                <form action="{{ route('consultations.prescription', $consultation->id) }}" method="POST" x-data="medicineSearch()" class="space-y-4">
                    @csrf
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search medicine
                        </label>
                        <input type="text" x-model="query" @input.debounce.300ms="search()"
                               placeholder="e.g. Paracetamol, Amoxicillin..."
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none text-sm transition-all" autocomplete="off">
                        <input type="hidden" name="medicine_id" x-model="selectedId">
                        <div x-show="results.length > 0" class="absolute z-10 w-full bg-white mt-1 border border-gray-200 rounded-xl shadow-lg max-h-48 overflow-y-auto" style="display: none;">
                            <ul>
                                <template x-for="item in results" :key="item.id">
                                    <li @click="select(item)" class="px-4 py-3 hover:bg-sky-50 cursor-pointer border-b last:border-0 text-sm transition-colors">
                                        <span class="font-medium text-gray-800" x-text="item.text"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sig. / Dosage <span class="text-red-500">*</span></label>
                            <input type="text" name="dosage" value="{{ old('dosage') }}" placeholder="e.g. 1 tab 3x a day" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm transition-all" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Frequency (optional)</label>
                            <input type="text" name="frequency" value="{{ old('frequency') }}" placeholder="e.g. After meals" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Duration (optional)</label>
                            <input type="text" name="duration" value="{{ old('duration') }}" placeholder="e.g. 7 days" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm transition-all">
                        </div>
                    </div>
                    <div class="max-w-xs">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity (optional)</label>
                        <input type="number" name="quantity" value="{{ old('quantity') }}" min="1" placeholder="e.g. 30" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm transition-all">
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" :disabled="!selectedId" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            + Add prescription
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function diagnosisSearch() {
        return {
            query: '',
            results: [],
            selectedId: null,
            async search() {
                if (this.query.length < 2) { this.results = []; return; }
                const response = await fetch('/search/diagnoses?query=' + encodeURIComponent(this.query));
                this.results = await response.json();
            },
            select(item) {
                this.query = item.text;
                this.selectedId = item.id;
                this.results = [];
            },
            setQuery(term) {
                this.query = term;
                this.search();
            }
        };
    }
    function medicineSearch() {
        return {
            query: '',
            results: [],
            selectedId: null,
            async search() {
                if (this.query.length < 2) { this.results = []; return; }
                const response = await fetch('/search/medicines?query=' + encodeURIComponent(this.query));
                this.results = await response.json();
            },
            select(item) {
                this.query = item.text;
                this.selectedId = item.id;
                this.results = [];
            }
        };
    }
</script>
@endsection
