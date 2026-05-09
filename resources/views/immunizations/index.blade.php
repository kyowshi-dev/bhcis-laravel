@extends('layouts.app')

@section('title', 'Immunization')

@section('content')
<div class="space-y-5 lg:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-display font-semibold text-2xl lg:text-3xl" style="color: var(--ink);">Immunization tracking</h1>
            <p class="text-sm mt-1" style="color: var(--ink-muted);">Record and view immunization history for patients.</p>
        </div>
        <a href="{{ route('patients.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-white text-sm font-semibold transition duration-200 hover:shadow-md" style="background: var(--accent);">
            Record immunization
        </a>
    </div>

    <div class="rounded-xl" x-data="patientSearch()">
        <div class="relative">
            <span class="absolute inset-y-0 flex items-center pointer-events-none" style="color: var(--ink-subtle); left: calc(0.75rem);">
                <i class="fa fa-search" aria-hidden="true"></i>
            </span>
            <input type="text" x-model="query" @input.debounce.300ms="search()"
                   placeholder="Search patient"
                   class="w-full pl-10 pr-4 py-2.5 rounded-lg border text-sm focus:outline-none focus:ring-2 transition"
                   style="border-color: var(--border); color: var(--ink); --tw-ring-color: var(--primary);"
                   autocomplete="off">
        </div>
        <div x-show="results.length > 0" class="mt-3 rounded-lg border overflow-hidden" style="display: none; border-color: var(--border); background: var(--bg-surface-elevated); box-shadow: var(--shadow-md);">
            <ul>
                <template x-for="patient in results" :key="patient.id">
                    <li class="border-b last:border-0 transition-colors hover:bg-black/[0.03]">
                        <a :href="patientUrl(patient.id)" class="block px-4 py-2.5">
                            <div class="font-medium text-sm" style="color: var(--ink);" x-text="patient.text"></div>
                            <div class="text-xs mt-0.5" style="color: var(--ink-muted);">
                                <span x-text="patient.subtext"></span>
                                <span class="font-semibold" style="color: var(--primary);"> - View immunizations</span>
                            </div>
                        </a>
                    </li>
                </template>
            </ul>
        </div>
        <div x-show="query.length > 1 && results.length === 0 && !loading" class="mt-2 text-xs" style="display: none; color: var(--ink-muted);">
            No patient found. <a href="{{ url('/patients/create') }}" class="font-semibold" style="color: var(--primary);">Register a new patient</a>.
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="rounded-xl border p-4 lg:p-5" style="background: var(--bg-surface); border-color: var(--border);">
            <p class="text-xs font-medium mb-0.5" style="color: var(--ink-muted);">Total doses given</p>
            <p class="text-2xl font-display font-semibold" style="color: var(--ink);">{{ number_format($totalGiven) }}</p>
        </div>
        <div class="rounded-xl border p-4 lg:p-5" style="background: var(--bg-surface); border-color: var(--border);">
            <p class="text-xs font-medium mb-0.5" style="color: var(--ink-muted);">Patients with records</p>
            <p class="text-2xl font-display font-semibold" style="color: var(--ink);">{{ number_format($patientsWithRecords) }}</p>
        </div>
    </div>

    <div>
        <h2 class="font-display font-semibold text-lg mb-3" style="color: var(--ink);">Recent immunizations</h2>
        <div class="rounded-xl border overflow-hidden" style="background: var(--bg-surface-elevated); border-color: var(--border);">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead style="background: var(--teal-soft);">
                        <tr>
                            <th class="px-3 lg:px-4 py-2 lg:py-3 text-left text-xs font-medium whitespace-nowrap" style="color: var(--ink-muted);">Date</th>
                            <th class="px-3 lg:px-4 py-2 lg:py-3 text-left text-xs font-medium whitespace-nowrap" style="color: var(--ink-muted);">Patient</th>
                            <th class="px-3 lg:px-4 py-2 lg:py-3 text-left text-xs font-medium whitespace-nowrap" style="color: var(--ink-muted);">Vaccine</th>
                            <th class="px-3 lg:px-4 py-2 lg:py-3 text-left text-xs font-medium whitespace-nowrap hidden sm:table-cell" style="color: var(--ink-muted);">Dose</th>
                            <th class="px-3 lg:px-4 py-2 lg:py-3 text-left text-xs font-medium whitespace-nowrap hidden md:table-cell" style="color: var(--ink-muted);">Given by</th>
                            <th class="px-3 lg:px-4 py-2 lg:py-3 text-right text-xs font-medium whitespace-nowrap" style="color: var(--ink-muted);"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border)]">
                        @forelse ($recentRecords as $r)
                            <tr class="transition-colors hover:bg-black/[0.02]">
                                <td class="px-3 lg:px-4 py-2 lg:py-3 whitespace-nowrap" style="color: var(--ink);">{{ \Carbon\Carbon::parse($r->date_given)->format('M d, Y') }}</td>
                                <td class="px-3 lg:px-4 py-2 lg:py-3" style="color: var(--ink);">{{ $r->last_name }}, {{ $r->first_name }}</td>
                                <td class="px-3 lg:px-4 py-2 lg:py-3" style="color: var(--ink);">{{ $r->vaccine_name }}</td>
                                <td class="px-3 lg:px-4 py-2 lg:py-3 hidden sm:table-cell" style="color: var(--ink-muted);">{{ $r->dose_number }}</td>
                                <td class="px-3 lg:px-4 py-2 lg:py-3 hidden md:table-cell" style="color: var(--ink-muted);">{{ $r->worker_name ?? '—' }}</td>
                                <td class="px-3 lg:px-4 py-2 lg:py-3 text-right whitespace-nowrap">
                                    <a href="{{ route('immunizations.patient', $r->patient_id) }}" class="text-sm font-medium hover:underline" style="color: var(--primary);">View patient</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 lg:px-4 py-6 text-center text-sm" style="color: var(--ink-muted);">No immunization records yet. Record a dose from a patient profile.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function patientSearch() {
        return {
            patientRouteTemplate: @json(route('immunizations.patient', ['id' => '__PATIENT_ID__'])),
            query: '',
            results: [],
            loading: false,
            patientUrl(patientId) {
                return this.patientRouteTemplate.replace('__PATIENT_ID__', patientId);
            },
            async search() {
                if (this.query.length < 2) { this.results = []; return; }
                this.loading = true;
                try {
                    const response = await fetch(`/search/patients?query=${this.query}`);
                    this.results = await response.json();
                } catch (e) { console.error('Search failed:', e); }
                this.loading = false;
            },
        };
    }
</script>
@endsection
