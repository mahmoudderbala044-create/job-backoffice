<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Job_Application;
use App\Models\Resume;
use App\Models\Job_Category;
use App\Models\Job_Vacancy;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;    

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       User::firstOrCreate(
    ['email' => 'admin@gmail.com'],
    [
        'name' => 'Admin',
        'password' => Hash::make('123456789'),
        'role' => 'admin',
    ]
);

        $jobData =  json_decode(file_get_contents(__DIR__ . '/../data/job_data.json'), true);

        foreach ($jobData['job_categories'] as $category) {
           Job_Category::firstOrCreate(['name'=>$category]);
        }

        foreach ($jobData['companies'] as $company) {
            $companyowner = User::firstOrCreate(
                ['email'=>fake()->unique()->safeEmail()],
                [
                'name'=>fake()->unique()->name(),
                'password' => Hash::make('123456789'),
                'role' => 'company-owner',
                ]
            );


            Company::firstOrCreate(
                ['name'=>$company['name']],
                [
                'address'=>$company['address'],
                'industry'=>$company['industry'],
                'website'=>$company['website'],
                'owner_id'=>$companyowner->id
            ]);
        }

    

    foreach ($jobData['job_vacancies'] as $job) {

        $jobcategory = Job_Category::where('name',$job['category'])->firstOrFail();
        $company = Company::where('name',$job['company'])->firstOrFail();

        Job_Vacancy::firstOrCreate([
            'title'=>$job['title'],
            'description'=>$job['description'],
            'location'=>$job['location'],
            'type'=>$job['type'],
            'salary'=>$job['salary'],
            'job_category_id'=>$jobcategory->id,
            'company_id'=>$company->id
        ]);
    }


        $applicationsData = json_decode(file_get_contents(__DIR__ . '/../data/job_applications.json'), true);

        foreach ($applicationsData['job_applications'] as $app) {
            $jobvacncy = Job_Vacancy::inRandomOrder()->first();

            $jobapplicant = User::firstOrCreate(
                ['email'=>fake()->unique()->safeEmail()],
                [
                    'name'=>fake()->unique()->name(),
                    'password' => Hash::make('123456789'),
                    'role' => 'job-seeker',
                ]
            );

            $resume=Resume::firstOrCreate(
                ['user_id'=>$jobapplicant->id],
                [
                    'file_name'=>$app['resume']['file_name'], 
                    'file_url'=>$app['resume']['file_url'],
                    'contact_detail'=>$app['resume']['contact_detail'],
                    'summary'=>$app['resume']['summary'],
                    'skills'=>$app['resume']['skills'],
                    'educations'=>$app['resume']['education'],
                    'experiences'=>$app['resume']['experience'],
                ]
            );

            Job_Application::firstOrCreate([
                'user_id'=>$jobapplicant->id,
                'resume_id'=>$resume->id,
                'job_vacancy_id'=>$jobvacncy->id,
                'status'=>$app['status'],
                'ai_generated_score'=>$app['ai_generated_score'],
                'ai_generated_feedback'=>$app['ai_generated_feedback'],
            ]);
        }
    }
}

    
