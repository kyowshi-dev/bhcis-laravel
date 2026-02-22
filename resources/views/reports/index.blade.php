@extends('layouts.app')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <div>
        <h1 class="text-2xl lg:text-3xl font-extrabold text-sky-700">FHSIS Reports</h1>
        <p class="text-xs lg:text-sm text-gray-600 mt-1">
            DOH Field Health Service Information System — official report formats for RHU.
        </p>
    </div>

    <form method="GET" action="{{ route('reports.index') }}" class="bg-white/80 rounded-xl lg:rounded-2xl shadow-sm border border-gray-200 p-3 lg:p-4 max-w-md">
        <h2 class="text-xs lg:text-sm font-semibold text-gray-700 mb-2 lg:mb-3">Report Period</h2>
        <div class="flex flex-wrap items-end gap-2 lg:gap-3">
            <div class="flex-1 min-w-[100px]">
                <label for="month" class="block text-xs font-medium text-gray-500 mb-1">Month</label>
                <select id="month" name="month" class="w-full rounded-xl border border-gray-300 text-xs lg:text-sm focus:border-sky-500 focus:ring-sky-500 py-2">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" @selected($month === $m)>{{ \Carbon\Carbon::createFromDate(null, $m, 1)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[80px]">
                <label for="year" class="block text-xs font-medium text-gray-500 mb-1">Year</label>
                <input type="number" id="year" name="year" value="{{ $year }}" min="2020" max="{{ date('Y') + 1 }}" class="w-full rounded-xl border border-gray-300 text-xs lg:text-sm focus:border-sky-500 focus:ring-sky-500 py-2">
            </div>
            <button type="submit" class="px-3 lg:px-4 py-2 rounded-xl bg-sky-600 text-white text-xs lg:text-sm font-semibold hover:bg-sky-700 whitespace-nowrap">Apply</button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 lg:gap-4">
        <a href="{{ route('reports.morbidity', ['month' => $month, 'year' => $year]) }}"
           class="block p-4 lg:p-6 rounded-xl lg:rounded-2xl border border-gray-200 bg-white/80 shadow-sm hover:border-sky-300 hover:shadow-md transition">
            <h3 class="font-bold text-sm lg:text-base text-gray-800 mb-1">Morbidity Report</h3>
            <p class="text-xs lg:text-sm text-gray-600">Leading causes of morbidity by diagnosis (ICD). FHSIS standard format.</p>
        </a>
        <a href="{{ route('reports.consultation-summary', ['month' => $month, 'year' => $year]) }}"
           class="block p-4 lg:p-6 rounded-xl lg:rounded-2xl border border-gray-200 bg-white/80 shadow-sm hover:border-sky-300 hover:shadow-md transition">
            <h3 class="font-bold text-sm lg:text-base text-gray-800 mb-1">Consultation Summary</h3>
            <p class="text-xs lg:text-sm text-gray-600">Total consultations and by status for the period. MCT-style.</p>
        </a>
    </div>
</div>
@endsection
