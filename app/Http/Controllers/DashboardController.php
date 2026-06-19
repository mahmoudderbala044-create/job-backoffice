<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use App\Models\Company;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            //last 30 days active users
            $active_users = User::where('last_login_at', '>=', now()->subDays(30))
                ->where('role', 'job-seeker')->count();

            //total job 
            $total_job = JobVacancy::whereNull('deleted_at')->count();

            //total application
            $total_application = JobApplication::whereNull('deleted_at')->count();

            //Most Applied Jobs
            $most_applied_jobs = JobVacancy::withCount('job_applications')
                ->whereNull('deleted_at')
                ->orderByDesc('job_applications_count')
                ->limit(5)
                ->get();

            //Top Converting Job Posts
            $converting = JobVacancy::withCount('job_applications as tottalcount')
                ->having('tottalcount', '>', 0)
                ->whereNull('deleted_at')
                ->orderByDesc('tottalcount')
                ->limit(5)
                ->get()
                ->map(function ($job) {
                    if ($job->view_count > 0) {
                        $job->conversion_rate = round($job->tottalcount / $job->view_count * 100, 1);
                    } else {
                        $job->conversion_rate = 0;
                    }
                    return $job;
                });
                
        } elseif ($user->role == 'company-owner') {
            $company = Company::where('owner_id', $user->id)->firstOrFail();

            //last 30 days active users who applied to this company's jobs
            $active_users = User::whereHas('job_applications', function($q) use ($company) {
                $q->whereHas('job_vacancy', function($q2) use ($company) {
                    $q2->where('company_id', $company->id);
                });
            })->where('last_login_at', '>=', now()->subDays(30))
              ->where('role', 'job-seeker')->count();

            //total job 
            $total_job = JobVacancy::where('company_id', $company->id)->whereNull('deleted_at')->count();

            //total application
            $total_application = JobApplication::whereHas('job_vacancy', function($q) use ($company) {
                $q->where('company_id', $company->id)->whereNull('deleted_at');
            })->count();

            //Most Applied Jobs
            $most_applied_jobs = JobVacancy::withCount('job_applications')
                ->where('company_id', $company->id)
                ->whereNull('deleted_at')
                ->orderByDesc('job_applications_count')
                ->limit(5)
                ->get();

            //Top Converting Job Posts
            $converting = JobVacancy::withCount('job_applications as tottalcount')
                ->having('tottalcount', '>', 0)
                ->where('company_id', $company->id)
                ->whereNull('deleted_at')
                ->orderByDesc('tottalcount')
                ->limit(5)
                ->get()
                ->map(function ($job) {
                    if ($job->view_count > 0) {
                        $job->conversion_rate = round($job->tottalcount / $job->view_count * 100, 1);
                    } else {
                        $job->conversion_rate = 0;
                    }
                    return $job;
                });
        } else {
            abort(403);
        }

        //analytics
        $analytics_data = [
            'active_users' => $active_users,
            'total_job' => $total_job,
            'total_application' => $total_application,
        ];

        

        return view('dashboard.index', compact('analytics_data', 'most_applied_jobs', 'converting'));
    }
}
