@extends('layouts.app')

@section('content')
<div class="space-y-6 lg:space-y-8">
    <div class="animate-in opacity-0 delay-1">
        <h1 class="font-display font-semibold text-2xl lg:text-3xl" style="color: var(--ink);">Dashboard</h1>
        <p class="text-sm mt-1" style="color: var(--ink-muted);">Overview of health center activity</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
        <div class="animate-in opacity-0 delay-2 p-5 lg:p-6 rounded-xl border transition-[transform,box-shadow] duration-200 hover:scale-[1.01] hover:shadow-md" style="background: var(--bg-surface); border-color: var(--border); box-shadow: var(--shadow-sm); border-left: 4px solid var(--primary);">
            <p class="text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--ink-muted);">Total patients</p>
            <p class="font-display font-semibold text-2xl lg:text-3xl" style="color: var(--ink);">{{ $totalPatients }}</p>
        </div>
        <div class="animate-in opacity-0 delay-3 p-5 lg:p-6 rounded-xl border transition-[transform,box-shadow] duration-200 hover:scale-[1.01] hover:shadow-md" style="background: var(--bg-surface); border-color: var(--border); box-shadow: var(--shadow-sm); border-left: 4px solid var(--accent);">
            <p class="text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--ink-muted);">Pending appointments</p>
            <p class="font-display font-semibold text-2xl lg:text-3xl" style="color: var(--ink);">{{ $pendingAppointments }}</p>
        </div>
        <div class="animate-in opacity-0 delay-4 p-5 lg:p-6 rounded-xl border transition-[transform,box-shadow] duration-200 hover:scale-[1.01] hover:shadow-md sm:col-span-2 lg:col-span-1" style="background: var(--bg-surface); border-color: var(--border); box-shadow: var(--shadow-sm); border-left: 4px solid var(--primary);">
            <p class="text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--ink-muted);">Health workers</p>
            <p class="font-display font-semibold text-2xl lg:text-3xl" style="color: var(--ink);">{{ $doctorsOnDuty }}</p>
        </div>
    </div>

    <div class="animate-in opacity-0 delay-5 rounded-xl border p-5 lg:p-6" style="background: var(--bg-surface); border-color: var(--border); box-shadow: var(--shadow-sm);">
        <h2 class="font-display font-semibold text-lg lg:text-xl mb-4" style="color: var(--ink);">Recent activity</h2>
        <ul class="divide-y divide-[var(--border)] space-y-0">
            @forelse($recentActivity as $activity)
                <li class="py-3 text-sm transition-colors hover:bg-black/[0.02]" style="color: var(--ink-muted);">
                    {{ $activity }}
                </li>
            @empty
                <li class="py-6 text-sm text-center" style="color: var(--ink-muted);">No recent activity.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
