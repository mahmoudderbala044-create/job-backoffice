<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Company Profile') }}
            </h2>

            @if(auth()->user()->role == 'admin')
            <a href="{{ route('company.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
                Back to Companies
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                
                <!-- Company Info & Actions -->
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $company->name }}</h3>
                        <div class="text-gray-600 space-y-1">
                             <p>
                                <span class="font-semibold">Company Owner:</span> 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 ml-1">
                                    {{ $company->user->name }}
                                </span>
                            </p>



                            <p>
                                <span class="font-semibold">Industry:</span> 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 ml-1">
                                    {{ $company->industry }}
                                </span>
                            </p>
                            <p><span class="font-semibold">Address:</span> {{ $company->address }}</p>
                            @if($company->website)
                                <p><span class="font-semibold">Website:</span> <a href="{{ $company->website }}" target="_blank" class="text-indigo-600 hover:underline">{{ $company->website }}</a></p>
                            @endif
                            <p><span class="font-semibold">Email:</span> {{ $company->user->email }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <a href="{{ auth()->user()->role == 'admin' ? route('company.edit', ['company' => $company->id ]) : route('my_company.edit', ['company' => $company->id ]) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white rounded-md font-semibold text-sm hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Edit Company
                        </a>
                        
                        
                        @if(auth()->user()->role == 'admin')    
                        <form action="{{ route('company.destroy', $company->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md font-semibold text-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors" onclick="return confirm('Are you sure you want to archive this company?')">
                                Archive
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                @if(auth()->user()->role == 'admin')  

                <!-- Tabs Navigation -->
                <div class="border-b border-gray-200 mb-6">
                    <div class="flex space-x-8">
                        @php $currentTab = request('tab', 'jobs'); @endphp
                        
                        <a href="{{ route('company.show', ['company' => $company->id, 'tab' => 'jobs']) }}" 
                           class="pb-4 px-1 text-sm font-medium transition-colors duration-200 {{ $currentTab == 'jobs' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                           Jobs
                        </a>
                        
                        <a href="{{ route('company.show', ['company' => $company->id, 'tab' => 'applications']) }}" 
                           class="pb-4 px-1 text-sm font-medium transition-colors duration-200 {{ $currentTab == 'applications' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                           Applications
                        </a>
                    </div>
                </div>

                <!-- Tabs Content -->
                <div class="mt-4">
                    <!-- Jobs Tab Content -->
                    <div id="jobs" class="{{ $currentTab == 'jobs' ? 'block' : 'hidden' }}">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Company Jobs</h3>
                        <div class="space-y-4">
                            @forelse ($company->job_vacancies as $job)
                                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                        <div>
                                            <h4 class="text-xl font-semibold text-gray-900">{{ $job->title }}</h4>
                                            <div class="mt-2 flex items-center space-x-4 text-sm text-gray-600">
                                                <div class="flex items-center">
                                                    <!-- Location Icon -->
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    {{ $job->location }}
                                                </div>
                                                <div class="flex items-center">
                                                    <!-- Briefcase Icon -->
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-md text-xs font-medium">{{ $job->type }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 sm:mt-0">
                                            <a href="{{ route('job-vacancy.show', $job->id) }}" class="inline-flex items-center px-4 py-2 border border-indigo-600 text-indigo-600 rounded-md hover:bg-indigo-50 transition-colors text-sm font-medium">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-gray-50 p-8 rounded-lg border border-dashed border-gray-300 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No jobs found</h3>
                                    <p class="mt-1 text-sm text-gray-500">This company hasn't posted any jobs yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Applications Tab Content -->
                    <div id="applications" class="{{ $currentTab == 'applications' ? 'block' : 'hidden' }}">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Job Applications</h3>
                        <div class="bg-gray-50 p-4 rounded border border-gray-200 text-gray-600">
                            @forelse ($company->job_applications as $application)
                                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                        <div>
                                            <h4 class="text-xl font-semibold text-gray-900">{{ $application->user->name }}</h4>
                                            <div class="mt-2 flex items-center space-x-4 text-sm text-gray-600">
                                                <div class="flex items-center">
                                                    <!-- Location Icon -->
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    {{ $application->job_vacancy->location }}
                                                </div>
                                                <div class="flex items-center">
                                                    <!-- Briefcase Icon -->
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-md text-xs font-medium">{{ $application->job_vacancy->type }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 sm:mt-0">
                                            <a href="{{ route('job-application.show', $application->id) }}" class="inline-flex items-center px-4 py-2 border border-indigo-600 text-indigo-600 rounded-md hover:bg-indigo-50 transition-colors text-sm font-medium">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-gray-50 p-8 rounded-lg border border-dashed border-gray-300 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No applications found</h3>
                                    <p class="mt-1 text-sm text-gray-500">This company hasn't received any applications yet.</p>
                                </div>
                            @endforelse
                            
                        </div>
                    </div>
                </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>
