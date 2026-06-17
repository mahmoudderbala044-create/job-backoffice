<x-app-layout>
<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Company') }}
        </h2>
        <a href="{{ route('company.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Back to Companies
        </a>
    </div>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form method="POST" action="{{ route('company.store') }}">
                    @csrf

                    <!-- Company Name -->
                    <div class="mt-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name') }}"
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
                            value="{{ old('address') }}"
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
                                <option value="{{ $industry }}" {{ old('industry') == $industry ? 'selected' : '' }}>{{ $industry }}</option>
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
                            value="{{ old('website') }}"
                            required
                            autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="e.g., https://www.google.com"
                        >
                        @error('website')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!--  date of owner_id -->
                           <div class="mt-4">
                        <label for="owner_name" class="block text-sm font-medium text-gray-700">Owner Name</label>
                        <input 
                            type="text" 
                            name="owner_name" 
                            id="owner_name" 
                            value="{{ old('owner_name') }}"
                            required
                            autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="e.g., Information Technology"
                        >
                        @error('owner_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
        <!-- Email Address -->
        <div>
            <x-input-label for="owner_email" :value="__('Email')" />
            <x-text-input id="owner_email" class="block mt-1 w-full" type="email" name="owner_email" value="{{ old('owner_email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('owner_email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password"/>
            <div class="relative " x-data="{ showPassword: false }">

            <x-text-input id="password" class="block mt-1 w-full"
                            
                            name="password"
                            x-bind:type="showPassword ? 'text' : 'password'"
                            required autocomplete="current-password" />

    
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <button type="button" @click="showPassword = !showPassword"  class="absolute inset-y-0 right-2 flex items-center text-gray-600">
            <!-- eye icon svg code closed eye -->
            <svg x-show="!showPassword" class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <!-- eye icon svg code open eye -->
             <svg x-show="showPassword" class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            </button>
            </div>
</div>

                   
                   

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Create Company
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>






</x-app-layout>