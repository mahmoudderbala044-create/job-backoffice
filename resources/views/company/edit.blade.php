@php
    $actionUrl = auth()->user()->role === 'admin' 
        ? route('company.update', $company->id) 
        : route('my_company.update');
@endphp


<x-app-layout>
<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') }}   {{ $company->name }} 
        </h2>
        @if(auth()->user()->role == 'admin')
        <a href="{{ route('company.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Back to Companies
        </a>
        @else
        <a href="{{ route('my_company.show') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Back to Companies
        </a>
        @endif
    </div>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form method="POST" action="{{ $actionUrl }}">                    
                    @csrf
                    @method('PUT')

                    <!-- Company Name -->
                    <div class="mt-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name', $company->name) }}"
                            required
                            autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="e.g., Information Technology"
                        >
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Company Address</label>
                        <input 
                            type="text" 
                            name="address" 
                            id="address" 
                            value="{{ old('address', $company->address) }}"
                            required
                            autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="e.g., Information Technology"
                        >
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                        <select 
                            name="industry" 
                            id="industry" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                            <option value="" disabled {{ old('industry') ? '' : 'selected' }}>Select an industry...</option>
                            @foreach ($industries as $industry)
                                <option value="{{ $industry }}" {{ old('industry', $company->industry) == $industry ? 'selected' : '' }}>{{ $industry }}</option>
                            @endforeach
                        </select>
                        @error('industry')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    <div class="mt-4">
                        <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                        <input 
                            type="text" 
                            name="website" 
                            id="website" 
                            value="{{ old('website', $company->website) }}"
                            required
                            autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="e.g., https://www.google.com"
                        >
                        @error('website')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Update Company
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>






</x-app-layout>