@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-4 lg:space-y-6">
    @if ($errors->any())
        <div class="rounded-xl border px-3 lg:px-4 py-2 lg:py-3 text-xs lg:text-sm"
             style="background: var(--accent-soft); border-color: var(--border); color: var(--accent);">
            <p class="font-semibold mb-1">Please review the details below.</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-display font-semibold text-2xl lg:text-3xl" style="color: var(--ink);">
                Register household
            </h1>
            <p class="text-sm mt-1" style="color: var(--ink-muted);">
                Add a new household record for barangay census and patient linking.
            </p>
        </div>

        <a href="{{ route('households.index') }}"
           class="text-xs lg:text-sm font-medium hover:underline"
           style="color: var(--primary);">
            Back to census list
        </a>
    </div>

    <form action="{{ route('households.store') }}" method="POST"
          class="rounded-2xl border p-5 lg:p-6 space-y-5 lg:space-y-6"
          style="background: var(--bg-surface-elevated); border-color: var(--border); box-shadow: var(--shadow-sm);">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-5">
            <div>
                <label for="zone_id" class="block text-xs lg:text-sm font-medium mb-1"
                       style="color: var(--ink-muted);">
                    Zone <span class="text-red-500">*</span>
                </label>
                <select id="zone_id" name="zone_id"
                        class="w-full rounded-lg border px-3 lg:px-4 py-2 lg:py-2.5 text-sm focus:outline-none focus:ring-2"
                        style="border-color: var(--border); color: var(--ink); --tw-ring-color: var(--primary);">
                    <option value="">Select zone</option>
                    @foreach ($zones as $zone)
                        <option value="{{ $zone->id }}" @selected(old('zone_id') == $zone->id)>
                            {{ $zone->zone_number }}
                        </option>
                    @endforeach
                </select>
                @error('zone_id')
                    <p class="mt-1 text-xs" style="color: var(--accent);">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="family_name_head" class="block text-xs lg:text-sm font-medium mb-1"
                       style="color: var(--ink-muted);">
                    Family name of head <span class="text-red-500">*</span>
                </label>
                <input id="family_name_head"
                       type="text"
                       name="family_name_head"
                       value="{{ old('family_name_head') }}"
                       class="w-full rounded-lg border px-3 lg:px-4 py-2 lg:py-2.5 text-sm focus:outline-none focus:ring-2"
                       style="border-color: var(--border); color: var(--ink); --tw-ring-color: var(--primary);">
                @error('family_name_head')
                    <p class="mt-1 text-xs" style="color: var(--accent);">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="contact_number" class="block text-xs lg:text-sm font-medium mb-1"
                   style="color: var(--ink-muted);">
                Contact number
            </label>
            <input id="contact_number"
                   type="text"
                   name="contact_number"
                   value="{{ old('contact_number') }}"
                   placeholder="e.g. 09XXXXXXXXX"
                   class="w-full rounded-lg border px-3 lg:px-4 py-2 lg:py-2.5 text-sm focus:outline-none focus:ring-2"
                   style="border-color: var(--border); color: var(--ink); --tw-ring-color: var(--primary);">
            @error('contact_number')
                <p class="mt-1 text-xs" style="color: var(--accent);">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2 lg:gap-3 pt-2">
            <a href="{{ route('households.index') }}"
               class="px-4 lg:px-5 py-2 lg:py-2.5 rounded-xl text-xs lg:text-sm font-medium border transition"
               style="border-color: var(--border); color: var(--ink-muted);">
                Cancel
            </a>
            <button type="submit"
                    class="px-5 lg:px-6 py-2 lg:py-2.5 rounded-xl text-xs lg:text-sm font-semibold text-white transition"
                    style="background: var(--accent); box-shadow: var(--shadow-sm);">
                Save household
            </button>
        </div>
    </form>
</div>
@endsection

