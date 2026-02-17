@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Register New Patient</h1>
        <a href="{{ route('patients.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
    </div>

    <form action="{{ route('patients.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
        @csrf

        <div class="mb-8 pb-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-green-700 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Household Information
            </h3>
            
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Household <span class="text-red-500">*</span></label>
                
                <select name="household_id" 
                        class="w-full p-2 border rounded focus:ring-green-500 focus:border-green-500 
                        @error('household_id') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                    
                    <option value="">-- Choose Family --</option>
                    @foreach($households as $h)
                        <option value="{{ $h->id }}" {{ old('household_id') == $h->id ? 'selected' : '' }}>
                            {{ $h->family_name_head }} (Zone {{ $h->zone_id }})
                        </option>
                    @endforeach
                </select>

                @error('household_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @else
                    <p class="text-xs text-gray-500 mt-1">If patient is transient, select the "Transient/Unmapped" household.</p>
                @enderror
            </div>
        </div>

        <div class="mb-8 pb-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-green-700 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Personal Information
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs uppercase text-gray-500 font-bold mb-1">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" 
                           value="{{ old('first_name') }}" 
                           class="w-full p-2 border rounded @error('first_name') border-red-500 bg-red-50 @enderror">
                    @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs uppercase text-gray-500 font-bold mb-1">Middle Name</label>
                    <input type="text" name="middle_name" 
                           value="{{ old('middle_name') }}"
                           class="w-full p-2 border rounded @error('middle_name') border-red-500 bg-red-50 @enderror">
                    @error('middle_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs uppercase text-gray-500 font-bold mb-1">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" 
                           value="{{ old('last_name') }}"
                           class="w-full p-2 border rounded @error('last_name') border-red-500 bg-red-50 @enderror">
                    @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-xs uppercase text-gray-500 font-bold mb-1">Suffix</label>
                    <input type="text" name="suffix" placeholder="Jr, III" value="{{ old('suffix') }}" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-xs uppercase text-gray-500 font-bold mb-1">Sex <span class="text-red-500">*</span></label>
                    <select name="sex" class="w-full p-2 border rounded @error('sex') border-red-500 @enderror">
                        <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs uppercase text-gray-500 font-bold mb-1">Birthdate <span class="text-red-500">*</span></label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                           class="w-full p-2 border rounded @error('date_of_birth') border-red-500 bg-red-50 @enderror">
                    @error('date_of_birth') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs uppercase text-gray-500 font-bold mb-1">Blood Type</label>
                    <select name="blood_type" class="w-full p-2 border rounded">
                        <option value="">Unknown</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $type)
                            <option value="{{ $type }}" {{ old('blood_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-xs uppercase text-gray-500 font-bold mb-1">Birth Place</label>
                <input type="text" name="birth_place" value="{{ old('birth_place') }}" 
                       placeholder="City/Municipality, Province" class="w-full p-2 border rounded">
            </div>
        </div>

        <div class="mb-8 pb-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-green-700 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Socio-Economic Status
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs uppercase text-gray-500 font-bold mb-1">Civil Status <span class="text-red-500">*</span></label>
                    <select name="civil_status" class="w-full p-2 border rounded @error('civil_status') border-red-500 @enderror">
                        @foreach(['Single', 'Married', 'Widowed', 'Separated', 'Common Law'] as $status)
                            <option value="{{ $status }}" {{ old('civil_status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs uppercase text-gray-500 font-bold mb-1">Highest Educational Attainment</label>
                    <select name="educational_attainment" class="w-full p-2 border rounded">
                        <option value="">Select Level</option>
                        @foreach(['None', 'Elementary', 'High School', 'College', 'Vocational'] as $edu)
                            <option value="{{ $edu }}" {{ old('educational_attainment') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs uppercase text-gray-500 font-bold mb-1">Employment</label>
                    <input type="text" name="employment_status" value="{{ old('employment_status') }}" 
                           placeholder="None If Unemployed" class="w-full p-2 border rounded">
                </div>
            </div>

            <div class="flex gap-6 mt-4 p-4 bg-gray-50 rounded border border-gray-100">
                <div class="flex items-center">
                    <input type="checkbox" name="has_4ps" id="4ps" value="1" 
                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                           {{ old('has_4ps') ? 'checked' : '' }}>
                    <label for="4ps" class="ml-2 block text-sm text-gray-900 font-bold">4Ps Member</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="has_nhts" id="nhts" value="1"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                           {{ old('has_nhts') ? 'checked' : '' }}>
                    <label for="nhts" class="ml-2 block text-sm text-gray-900 font-bold">NHTS / Indigent</label>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('patients.index') }}" class="py-2 px-6 border border-gray-300 rounded text-gray-600 hover:bg-gray-100">Cancel</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow-lg flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Save Patient Record
            </button>
        </div>

    </form>
</div>
@endsection