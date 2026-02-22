@extends('layouts.app')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <div>
        <h1 class="text-2xl lg:text-3xl font-extrabold text-sky-700">Consultation History</h1>
        <p class="text-xs lg:text-sm text-gray-600 mt-1">
            View and search past consultations.
        </p>
    </div>

    <form method="GET" action="{{ route('consultations.index') }}" class="bg-white/80 rounded-xl lg:rounded-2xl shadow-sm border border-gray-200 p-3 lg:p-4">
        <div class="flex flex-col md:flex-row md:items-end gap-3">
            <div class="flex-1">
                <label for="query" class="sr-only">Search</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">🔍</span>
                    <input
                        type="text"
                        id="query"
                        name="query"
                        value="{{ request('query') }}"
                        placeholder="Search by patient, ID, or diagnosis..."
                        class="w-full pl-9 pr-4 py-2 lg:py-2.5 rounded-xl border border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-sm"
                    >
                </div>
            </div>
            <div class="flex flex-wrap items-end gap-2 lg:gap-3">
                <div class="flex-1 min-w-[120px]">
                    <label for="date_from" class="block text-xs font-medium text-gray-500 mb-1">From</label>
                    <input
                        type="text"
                        id="date_from"
                        name="date_from"
                        value="{{ request('date_from') }}"
                        placeholder="dd/mm/yyyy"
                        class="w-full px-3 py-2 rounded-xl border border-gray-300 text-sm focus:border-sky-500 focus:ring-sky-500"
                    >
                </div>
                <div class="flex-1 min-w-[120px]">
                    <label for="date_to" class="block text-xs font-medium text-gray-500 mb-1">To</label>
                    <input
                        type="text"
                        id="date_to"
                        name="date_to"
                        value="{{ request('date_to') }}"
                        placeholder="dd/mm/yyyy"
                        class="w-full px-3 py-2 rounded-xl border border-gray-300 text-sm focus:border-sky-500 focus:ring-sky-500"
                    >
                </div>
                <button
                    type="submit"
                    class="px-4 py-2 rounded-xl bg-sky-600 text-white text-xs lg:text-sm font-semibold hover:bg-sky-700 transition whitespace-nowrap"
                >
                    Search
                </button>
            </div>
        </div>
    </form>

    <div class="space-y-3 lg:space-y-4">
        @forelse ($consultations as $consultation)
            <div class="bg-white/80 rounded-xl lg:rounded-2xl shadow-sm border border-gray-200 p-4 lg:p-5 hover:border-sky-200 transition">
                <div class="flex flex-col gap-3">
                    <div class="flex flex-wrap items-start justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1 lg:mb-2">
                                <span class="font-semibold text-sm lg:text-base text-gray-800">
                                    {{ $consultation->patient_last_name }}, {{ $consultation->patient_first_name }}
                                    <span class="text-sky-600 font-medium">(PT{{ str_pad($consultation->patient_id, 3, '0', STR_PAD_LEFT) }})</span>
                                </span>
                            </div>
                            <p class="text-xs lg:text-sm text-gray-500 mb-1">
                                {{ \Carbon\Carbon::parse($consultation->created_at)->format('Y-m-d \a\t h:i A') }}
                            </p>
                            <p class="text-xs lg:text-sm text-gray-600 mb-1">
                                <span class="font-medium">Doctor:</span>
                                {{ $consultation->worker_first_name }} {{ $consultation->worker_last_name }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="inline-flex items-center px-2 lg:px-3 py-0.5 lg:py-1 rounded-full text-xs font-semibold
                                @if ($consultation->status === 'completed') bg-emerald-100 text-emerald-700
                                @elseif ($consultation->status === 'referred') bg-amber-100 text-amber-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $consultation->status)) }}
                            </span>
                            <a href="{{ route('consultations.show', $consultation->id) }}"
                               class="inline-flex items-center gap-1 text-xs lg:text-sm font-semibold text-sky-600 hover:text-sky-800 whitespace-nowrap">
                                View
                            </a>
                        </div>
                    </div>
                    @php
                        $diagnoses = $diagnosisByConsultation[$consultation->id] ?? [];
                        $treatments = $treatmentByConsultation[$consultation->id] ?? [];
                    @endphp
                    @if (!empty($diagnoses))
                        <p class="text-xs lg:text-sm">
                            <span class="font-medium text-gray-600">Diagnosis:</span>
                            <span class="flex flex-wrap gap-1 mt-1">
                                @foreach ($diagnoses as $d)
                                    <span class="inline-block px-2 py-0.5 rounded-lg bg-sky-100 text-sky-800 text-xs font-medium">{{ $d }}</span>
                                @endforeach
                            </span>
                        </p>
                    @endif
                    @if (!empty($treatments))
                        <p class="text-xs lg:text-sm text-gray-600">
                            <span class="font-medium">Treatment:</span>
                            <span class="ml-1">{{ implode('. ', $treatments) }}</span>
                        </p>
                    @else
                        <p class="text-xs lg:text-sm text-gray-500 italic">No treatment recorded.</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white/80 rounded-xl lg:rounded-2xl shadow-sm border border-gray-200 p-6 lg:p-8 text-center text-gray-500 text-sm">
                No consultations match your criteria.
            </div>
        @endforelse
    </div>

    <div class="flex flex-wrap gap-4 lg:gap-6 py-3 lg:py-4 px-4 lg:px-5 rounded-xl lg:rounded-2xl bg-gray-50 border border-gray-200">
        <div>
            <span class="text-xs lg:text-sm text-gray-500 block">Total</span>
            <span class="text-xl lg:text-2xl font-bold text-gray-800">{{ $totalConsultations }}</span>
        </div>
        <div>
            <span class="text-xs lg:text-sm text-gray-500 block">This Week</span>
            <span class="text-xl lg:text-2xl font-bold text-gray-800">{{ $thisWeekCount }}</span>
        </div>
        <div>
            <span class="text-xs lg:text-sm text-gray-500 block">Completed</span>
            <span class="text-xl lg:text-2xl font-bold text-emerald-600">{{ $completedCount }}</span>
        </div>
    </div>
</div>
@endsection
