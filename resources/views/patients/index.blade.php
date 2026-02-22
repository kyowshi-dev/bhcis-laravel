@extends('layouts.app')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl lg:text-3xl font-extrabold text-sky-700">Patient Records</h1>
            <p class="text-xs lg:text-sm text-gray-600 mt-1">
                Search and manage patient information.
            </p>
        </div>

        <a href="{{ url('/patients/create') }}"
           class="inline-flex items-center justify-center px-4 lg:px-5 py-2 lg:py-2.5 rounded-xl lg:rounded-2xl bg-gradient-to-r from-sky-500 to-emerald-500 text-xs lg:text-sm font-semibold text-white shadow-md hover:shadow-xl transition">
            + Register New Patient
        </a>
    </div>

    <div class="bg-white/80 rounded-xl lg:rounded-2xl shadow-sm border border-gray-200 p-3 lg:p-4" x-data="patientSearch()">
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                🔍
            </span>
            <input
                type="text"
                x-model="query"
                @input.debounce.300ms="search()"
                placeholder="Search by patient name or ID..."
                class="w-full pl-9 pr-4 py-2 lg:py-2.5 rounded-xl border border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-sm"
                autocomplete="off"
            >
        </div>

        <div x-show="results.length > 0" class="mt-3 border border-gray-200 rounded-xl bg-white shadow-lg overflow-hidden" style="display: none;">
            <ul>
                <template x-for="patient in results" :key="patient.id">
                    <li class="border-b last:border-0 hover:bg-sky-50 cursor-pointer px-3 lg:px-4 py-2 lg:py-2.5 transition">
                        <a :href="'/patients/' + patient.id" class="block">
                            <div class="font-semibold text-sm text-gray-800" x-text="patient.text"></div>
                            <div class="text-xs text-gray-500" x-text="patient.subtext"></div>
                        </a>
                    </li>
                </template>
            </ul>
        </div>

        <div x-show="query.length > 1 && results.length === 0 && !loading"
             class="mt-2 text-gray-500 text-xs"
             style="display: none;">
            No patient found. You may register a new record.
        </div>
    </div>

    <div class="bg-white/80 rounded-xl lg:rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-xs lg:text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-2 lg:px-4 py-2 lg:py-3 font-semibold text-gray-500 uppercase text-xs whitespace-nowrap">ID</th>
                        <th class="px-2 lg:px-4 py-2 lg:py-3 font-semibold text-gray-500 uppercase text-xs whitespace-nowrap">Name</th>
                        <th class="px-2 lg:px-4 py-2 lg:py-3 font-semibold text-gray-500 uppercase text-xs whitespace-nowrap">Age</th>
                        <th class="px-2 lg:px-4 py-2 lg:py-3 font-semibold text-gray-500 uppercase text-xs whitespace-nowrap hidden sm:table-cell">Gender</th>
                        <th class="px-2 lg:px-4 py-2 lg:py-3 font-semibold text-gray-500 uppercase text-xs whitespace-nowrap hidden md:table-cell">Phone</th>
                        <th class="px-2 lg:px-4 py-2 lg:py-3 font-semibold text-gray-500 uppercase text-xs whitespace-nowrap hidden lg:table-cell">Last Visit</th>
                        <th class="px-2 lg:px-4 py-2 lg:py-3 font-semibold text-gray-500 uppercase text-xs whitespace-nowrap">Status</th>
                        <th class="px-2 lg:px-4 py-2 lg:py-3 font-semibold text-gray-500 uppercase text-xs text-right whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($patients as $patient)
                        <tr class="hover:bg-sky-50/50 transition-colors">
                            <td class="px-2 lg:px-4 py-2 lg:py-2.5 font-semibold text-gray-700 whitespace-nowrap">
                                PT{{ str_pad($patient->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-2 lg:px-4 py-2 lg:py-2.5 text-gray-800">
                                <div class="font-medium">{{ $patient->last_name }}, {{ $patient->first_name }}</div>
                                <div class="text-xs text-gray-500 sm:hidden">{{ $patient->sex }}</div>
                            </td>
                            <td class="px-2 lg:px-4 py-2 lg:py-2.5 text-gray-700 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}
                            </td>
                            <td class="px-2 lg:px-4 py-2 lg:py-2.5 text-gray-700 whitespace-nowrap hidden sm:table-cell">
                                {{ $patient->sex }}
                            </td>
                            <td class="px-2 lg:px-4 py-2 lg:py-2.5 text-gray-700 whitespace-nowrap hidden md:table-cell">
                                {{ $patient->contact_number ?? '—' }}
                            </td>
                            <td class="px-2 lg:px-4 py-2 lg:py-2.5 text-gray-700 whitespace-nowrap hidden lg:table-cell">
                                @if ($patient->last_visit)
                                    {{ \Carbon\Carbon::parse($patient->last_visit)->format('Y-m-d') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-2 lg:px-4 py-2 lg:py-2.5">
                                <span class="inline-flex items-center px-2 lg:px-3 py-0.5 lg:py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    Active
                                </span>
                            </td>
                            <td class="px-2 lg:px-4 py-2 lg:py-2.5 text-right whitespace-nowrap">
                                <a href="{{ route('patients.show', $patient->id) }}"
                                   class="text-xs lg:text-sm font-semibold text-sky-600 hover:text-sky-800">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-sm text-gray-500">
                                No patients found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $patients->links() }}
    </div>
</div>

<script>
    function patientSearch() {
        return {
            query: '',
            results: [],
            loading: false,
            async search() {
                if (this.query.length < 2) {
                    this.results = [];
                    return;
                }
                this.loading = true;
                try {
                    const response = await fetch(`/search/patients?query=${this.query}`);
                    this.results = await response.json();
                } catch (error) {
                    console.error('Search failed:', error);
                }
                this.loading = false;
            },
        };
    }
</script>
@endsection
