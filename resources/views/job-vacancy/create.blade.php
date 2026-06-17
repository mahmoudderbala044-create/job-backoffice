<x-app-layout>
<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Job Vacancy') }}
        </h2>
        <a href="{{ route('job-vacancy.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Back to Job Vacancies
        </a>
    </div>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form method="POST" action="{{ route('job-vacancy.store') }}">
                    @csrf

                    <!-- Job Title -->

                    <div class="mt-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            value="{{ old('title') }}"
                            required
                            autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="e.g., Software Engineer"
                        >
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>




                    <div class="mt-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Job Description</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Enter job description..."
                        >
                            {{ old('description') }}
                        </textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>




                    <div class="mt-4">
                        <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                        <input 
                            type="text" 
                            name="salary" 
                            id="salary" 
                            value="{{ old('salary') }}"
                            required
                            autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="e.g., 10000"
                        >
                        @error('salary')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    <div class="mt-4">









                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input 
                            type="text" 
                            name="location" 
                            id="location" 
                            value="{{ old('location') }}"
                            required
                            autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            
                        >
                        @error('location')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror


                        
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select
                            name="type" 
                            id="type" 
                            value="{{ old('type') }}"
                            required
                            autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>Select an industry...</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror



                         <label for="required_skills" class="block text-sm font-medium text-gray-700">required_skills</label>
                        <input
                            type="text"
                            name="required_skills" 
                            id="required_skills" 
                            value="{{ old('required_skills') }}"
                            required
                            autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                        @error('required_skills')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror


                        <label for="company_id" class="block text-sm font-medium text-gray-700">company_id</label>
                        <select
                            name="company_id" 
                            id="company_id" 
                            value="{{ old('company_id') }}"
                            required
                            autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                            <option value="" disabled {{ old('company_id') ? '' : 'selected' }}>Select an industry...</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror



                          <label for="job_category_id" class="block text-sm font-medium text-gray-700">job_category_id</label>
                        <select
                            name="job_category_id" 
                            id="job_category_id" 
                            value="{{ old('job_category_id') }}"
                            required
                            autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                            <option value="" disabled {{ old('job_category_id') ? '' : 'selected' }}>Select an industry...</option>
                            @foreach ($job_categories as $job_category)
                                <option value="{{ $job_category->id }}" {{ old('job_category_id') == $job_category->id ? 'selected' : '' }}>{{ $job_category->name }}</option>
                            @endforeach
                        </select>
                        @error('job_category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror











                        

                   
                   

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Create Job Vacancy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>






</x-app-layout>