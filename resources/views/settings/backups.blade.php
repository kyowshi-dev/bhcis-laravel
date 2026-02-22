@extends('layouts.app')

@section('title', 'Backup Settings')

@section('content')
<div class="space-y-5 lg:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-display font-semibold text-2xl lg:text-3xl" style="color: var(--ink);">Backups</h1>
            <p class="text-sm mt-1" style="color: var(--ink-muted);">Export the database for backup or transfer to another server.</p>
        </div>
        <a href="{{ route('settings.index') }}" class="text-sm font-medium transition hover:underline" style="color: var(--primary);">← Back to Settings</a>
    </div>

    @if (session('success'))
        <div class="rounded-xl border px-4 py-3" style="background: var(--teal-soft); border-color: var(--primary); color: var(--primary);">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="rounded-xl border px-4 py-3" style="background: var(--accent-soft); border-color: var(--accent); color: var(--accent);">
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-xl border p-5 lg:p-6 max-w-lg" style="background: var(--bg-surface); border-color: var(--border);">
        <p class="text-sm mb-4" style="color: var(--ink-muted);">Current database: <strong style="color: var(--ink);">{{ $driver }}</strong>. Download a full copy now and store it in a safe place for disaster recovery.</p>
        <form action="{{ route('settings.backups.export') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2.5 rounded-xl text-white text-sm font-semibold transition duration-200 hover:shadow-md" style="background: var(--accent);">
                Download database export
            </button>
        </form>
    </div>
</div>
@endsection
