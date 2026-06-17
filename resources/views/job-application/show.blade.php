<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $job_application->user->name }} | Applied to {{ $job_application->job_vacancy?->title ?? 'N/A' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('job-application.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none transition ease-in-out duration-150">
                    &larr; Back
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-6">
                <!-- Top Section: Info & Buttons -->
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Application Details</h3>
                        <div class="space-y-1 text-sm text-gray-600">
                            <p><span class="font-semibold">Applicant:</span> {{ $job_application->user->name }}</p>
                            <p><span class="font-semibold">Job Vacancy:</span> {{ $job_application->job_vacancy?->title ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Company:</span> {{ $job_application->job_vacancy?->company?->name ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Status:</span> {{ $job_application->status }}</p>
                            <p><span class="font-semibold">Resume:</span> 
                                @if($job_application->resume)
                                    <a href="{{ $job_application->resume->file_url }}" target="_blank" class="text-blue-600 hover:underline">{{ $job_application->resume->file_url }}</a>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <a href="{{ route('job-application.edit', $job_application->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none transition ease-in-out duration-150">
                            Edit
                        </a>
                        <form action="{{ route('job-application.destroy', $job_application->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-600 active:bg-red-700 focus:outline-none transition ease-in-out duration-150" onclick="return confirm('Are you sure?')">
                                Archive
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="border-b border-gray-200 mb-6">
                    <div class="flex space-x-8">
                        @php $currentTab = request('tab', 'resume'); @endphp
                        
                        <a href="{{ route('job-application.show', ['job_application' => $job_application->id, 'tab' => 'resume']) }}" 
                           class="pb-4 px-1 text-sm font-medium transition-colors duration-200 {{ $currentTab == 'resume' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                           Resume
                        </a>
                        
                        <a href="{{ route('job-application.show', ['job_application' => $job_application->id, 'tab' => 'ai_feedback']) }}" 
                           class="pb-4 px-1 text-sm font-medium transition-colors duration-200 {{ $currentTab == 'ai_feedback' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                           Ai Feedback
                        </a>
                    </div>
                </div>

                <!-- Tabs Content -->
                <div class="mt-4 text-sm text-gray-700">
                    <!-- Resume Tab Content -->
                    <div id="resume" class="{{ $currentTab == 'resume' ? 'block' : 'hidden' }}">
                        @if($job_application->resume)
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-2">Summary</h4>
                                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $job_application->resume->summary ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-2">Skills</h4>
                                    <p class="text-gray-600 leading-relaxed">{{ $job_application->resume->skills ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-2">Experience</h4>
                                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $job_application->resume->experiences ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-2">Education</h4>
                                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $job_application->resume->educations ?? 'N/A' }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500">No resume attached.</p>
                        @endif
                    </div>

                    <!-- AI Feedback Tab Content -->
                    <div id="ai_feedback" class="{{ $currentTab == 'ai_feedback' ? 'block' : 'hidden' }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div>
                                <h4 class="font-bold text-gray-900 mb-2">Score</h4>
                                <p class="text-gray-600 leading-relaxed">{{ $job_application->ai_generated_score ?? 'N/A' }}%</p>
                            </div>
                            <div class="md:col-span-3">
                                <h4 class="font-bold text-gray-900 mb-2">Feedback</h4>
                                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $job_application->ai_generated_feedback ?? 'No feedback available.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
