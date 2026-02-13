@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Patient Records</h1>
    <p class="text-gray-500 mb-6">Search for an existing patient or register a new one.</p>

    <div class="relative" x-data="patientSearch()">

        <div class="flex gap-2">
            <input 
                type="text" 
                x-model="query"
                @input.debounce.300ms="search()"
                placeholder="Enter patient last name or first name..." 
                class="w-full p-4 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
                autocomplete="off"
            >

            <a href="{{ url('/patients/create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-4 rounded-lg font-medium shadow-sm flex items-center gap-2 whitespace-nowrap">
                <span>+ New Patient</span>
            </a>
        </div>

        <div x-show="results.length > 0" class="absolute z-10 w-full bg-white mt-1 border border-gray-200 rounded-lg shadow-xl overflow-hidden" style="display: none;">
            <ul>
                <template x-for="patient in results" :key="patient.id">
                    <li class="border-b last:border-0 hover:bg-gray-50 cursor-pointer p-3 transition">
                        <a :href="'/patients/' + patient.id" class="block">
                            <div class="font-bold text-gray-800" x-text="patient.text"></div>
                            <div class="text-sm text-gray-500" x-text="patient.subtext"></div>
                        </a>
                    </li>
                </template>
            </ul>
        </div>

        <div x-show="query.length > 1 && results.length === 0 && !loading" class="mt-2 text-gray-500 text-sm" style="display: none;">
            No patient found. Please register a new record.
        </div>
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
                    // Call the API we created earlier
                    let response = await fetch(`/search/patients?query=${this.query}`);
                    this.results = await response.json();
                } catch (error) {
                    console.error('Search failed:', error);
                }
                this.loading = false;
            }
        }
    }
</script>
@endsection

