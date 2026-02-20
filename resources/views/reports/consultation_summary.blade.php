@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('reports.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-800">← All Reports</a>
            <h1 class="text-2xl font-extrabold text-gray-800 mt-2">Consultation Summary (MCT)</h1>
            <p class="text-sm text-gray-600 mt-1">Monthly consolidation — {{ $reportDate }}</p>
        </div>
        <form method="GET" action="{{ route('reports.consultation-summary') }}" class="flex items-end gap-2">
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
            <p class="text-sm text-gray-600">FHSIS — Monthly Consolidation Table (Consultations)</p>
            <p class="text-sm text-gray-500 mt-1">Report Period: {{ $reportDate }}</p>
        </div>

        <div class="p-6">
            <p class="text-lg font-bold text-gray-800 mb-4">Total consultations: {{ number_format($total) }}</p>
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-100 border border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-3 font-semibold text-gray-700 text-right w-32">Count</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($byStatus as $row)
                        <tr>
                            <td class="px-4 py-3 text-gray-800">{{ ucfirst(str_replace('_', ' ', $row->status)) }}</td>
                            <td class="px-4 py-3 text-right font-medium text-gray-800">{{ number_format($row->count) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-4 text-center text-gray-500">No consultations for this period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
