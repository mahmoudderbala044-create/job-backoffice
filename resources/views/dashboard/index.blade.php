<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Active Users</div>
                    <div class="text-3xl font-bold text-blue-700 mb-1">{{$analytics_data['active_users']}}</div>
                    <div class="text-xs text-gray-400">Last 30 days</div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 relative">
                    <div class="text-sm font-medium text-gray-600 mb-2">Active Job Postings</div>
                    <div class="text-3xl font-bold text-blue-700 mb-1">{{$analytics_data['total_job']}}</div>
                    <div class="text-xs text-gray-400">Currently active</div>
                    <!-- Icon placeholder similar to the screenshot -->
                    <div class="absolute bottom-6 right-6 text-gray-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                        </svg>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Total Applications</div>
                    <div class="text-3xl font-bold text-blue-700 mb-1">{{$analytics_data['total_application']}}</div>
                    <div class="text-xs text-gray-400">All time</div>
                </div>
            </div>

            <!-- Table 1 Section: Most Applied Jobs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Most Applied Jobs</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                                    <th class="pb-4 pr-4">Job Title</th>
                                    <th class="pb-4 px-4">Company</th>
                                    <th class="pb-4 pl-4">Applications</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                
                                
                                @foreach($most_applied_jobs as $job)
                                <tr>
                                    <td class="py-4 pr-4 text-gray-800 font-medium">{{$job->title}}</td>
                                    <td class="py-4 px-4 text-gray-600">{{$job->company->name}}</td>
                                    <td class="py-4 pl-4 text-gray-800 font-medium">{{$job->job_applications->count()}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Table 2 Section: Top Converting Job Posts -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Top Converting Job Posts</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                                    <th class="pb-4 pr-4">Job Title</th>
                                    <th class="pb-4 px-4">Views</th>
                                    <th class="pb-4 px-4">Applications</th>
                                    <th class="pb-4 pl-4">Conversion Rate</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                
                                @foreach($converting as $job)
                                <tr>
                                    <td class="py-4 pr-4 text-gray-800 font-medium">{{$job->title}}</td>
                                    <td class="py-4 px-4 text-gray-600">{{$job->view_count}}</td>
                                    <td class="py-4 px-4 text-gray-600">{{$job->tottalcount}}</td>
                                    <td class="py-4 pl-4 text-gray-800 font-medium">{{$job->conversion_rate}}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
