@extends('layouts.app')

@section('content')
<div class="space-y-5 lg:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-display font-semibold text-2xl lg:text-3xl" style="color: var(--ink);">
                Household census
            </h1>
            <p class="text-sm mt-1" style="color: var(--ink-muted);">
                Registered households by zone for barangay census and patient mapping.
            </p>
        </div>

        <a href="{{ route('households.create') }}"
           class="inline-flex items-center justify-center px-4 lg:px-5 py-2 lg:py-2.5 rounded-xl text-xs lg:text-sm font-semibold text-white transition"
           style="background: var(--accent); box-shadow: var(--shadow-sm);">
            Add household
        </a>
    </div>

    @if (session('success'))
        <div class="rounded-xl border px-3 lg:px-4 py-2 text-xs lg:text-sm"
             style="background: var(--teal-soft); border-color: var(--border); color: var(--primary);">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border overflow-hidden"
         style="background: var(--bg-surface-elevated); border-color: var(--border); box-shadow: var(--shadow-sm);">
        <div class="px-4 lg:px-5 py-3 border-b" style="border-color: var(--border); background: var(--bg-surface);">
            <p class="text-xs lg:text-sm" style="color: var(--ink-muted);">
                Total households: <span class="font-semibold" style="color: var(--ink);">{{ $households->total() }}</span>
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-xs lg:text-sm">
                <thead>
                    <tr style="background: var(--teal-soft);">
                        <th class="px-3 lg:px-4 py-2.5 lg:py-3 font-semibold uppercase tracking-wide"
                            style="color: var(--ink-muted);">
                            Zone
                        </th>
                        <th class="px-3 lg:px-4 py-2.5 lg:py-3 font-semibold uppercase tracking-wide"
                            style="color: var(--ink-muted);">
                            Family name (head)
                        </th>
                        <th class="px-3 lg:px-4 py-2.5 lg:py-3 font-semibold uppercase tracking-wide"
                            style="color: var(--ink-muted);">
                            Contact number
                        </th>
                        <th class="px-3 lg:px-4 py-2.5 lg:py-3 font-semibold uppercase tracking-wide"
                            style="color: var(--ink-muted);">
                            Registered at
                        </th>
                        <th class="px-3 lg:px-4 py-2.5 lg:py-3 text-right font-semibold uppercase tracking-wide"
                            style="color: var(--ink-muted);">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($households as $household)
                        <tr class="border-b last:border-b-0" style="border-color: var(--border);">
                            <td class="px-3 lg:px-4 py-2.5 lg:py-3" style="color: var(--ink);">
                                {{ $household->zone_number }}
                            </td>
                            <td class="px-3 lg:px-4 py-2.5 lg:py-3 font-medium" style="color: var(--ink);">
                                {{ $household->family_name_head }}
                            </td>
                            <td class="px-3 lg:px-4 py-2.5 lg:py-3" style="color: var(--ink-muted);">
                                {{ $household->contact_number ?: '—' }}
                            </td>
                            <td class="px-3 lg:px-4 py-2.5 lg:py-3" style="color: var(--ink-muted);">
                                {{ optional($household->created_at)->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-5 text-center text-sm" style="color: var(--ink-muted);">
                                No households registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 lg:px-5 py-3 border-t" style="border-color: var(--border); background: var(--bg-surface);">
            {{ $households->links() }}
        </div>
    </div>
</div>
@endsection

