@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('reports.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-800">← All Reports</a>
            <h1 class="text-2xl font-extrabold text-gray-800 mt-2">FHSIS Morbidity Report</h1>
            <p class="text-sm text-gray-600 mt-1">Leading Causes of Morbidity — {{ $reportDate }}</p>
        </div>
        <form method="GET" action="{{ route('reports.morbidity') }}" class="flex items-end gap-2">
            <select name="month" class="rounded-lg border border-gray-300 text-sm">
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" @selected($month === $m)>{{ \Carbon\Carbon::createFromDate(null, $m, 1)->format('F') }}</option>
                @endforeach
            </select>
            <input type="number" name="year" value="{{ $year }}" min="2020" max="{{ date('Y') + 1 }}" class="w-20 rounded-lg border border-gray-300 text-sm">
            <button type="submit" class="px-3 py-1.5 rounded-lg bg-sky-600 text-white text-sm font-medium">Go</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden print:shadow-none">
        <div class="p-6 border-b border-gray-200 bg-gray-50/80">
            <p class="font-semibold text-gray-700">Barangay Health Center Information System — Sta. Ana</p>
            <p class="text-sm text-gray-600">Department of Health — Field Health Service Information System (FHSIS)</p>
            <p class="text-sm text-gray-500 mt-1">Report Period: {{ $reportDate }}</p>
        </div>

        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-700 w-16">Rank</th>
                    <th class="px-4 py-3 font-semibold text-gray-700 w-24">ICD Code</th>
                    <th class="px-4 py-3 font-semibold text-gray-700">Diagnosis / Cause</th>
                    <th class="px-4 py-3 font-semibold text-gray-700 w-24 text-right">No. of Cases</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($rows as $rank => $row)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $rank + 1 }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $row->diagnosis_code }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $row->diagnosis_name }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-800">{{ number_format($row->case_count) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">No morbidity data for this period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($rows->isNotEmpty())
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 text-sm font-semibold text-gray-700">
                Total cases: {{ number_format($totalCases) }}
            </div>
        @endif
    </div>
</div>
@endsection
