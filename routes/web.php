<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\UserController;

 

// share routs
Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    
    
    Route::resource('job-vacancy', JobVacancyController::class);
    Route::post('job-vacancy/restore/{id}', [JobVacancyController::class, 'restore'])->name('job-vacancy.restore');

  
    
    Route::resource('job-application', JobApplicationController::class);
    Route::post('job-application/restore/{id}', [JobApplicationController::class, 'restore'])->name('job-application.restore');



});

//company_owner routes
Route::middleware(['auth', 'role:company-owner'])->group(function () {
    
    Route::get('my_company',[CompanyController::class,'show'])->name('my_company.show');
    Route::get('my_company/edit',[CompanyController::class,'edit'])->name('my_company.edit');
    Route::put('my_company/update',[CompanyController::class,'update'])->name('my_company.update');






}); 


//admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('user', UserController::class);
    Route::post('user/restore/{id}', [UserController::class, 'restore'])->name('user.restore');

    Route::resource('category', JobCategoryController::class);
    Route::post('category/restore/{id}', [JobCategoryController::class, 'restore'])->name('category.restore');

    Route::resource('company', CompanyController::class);
    Route::post('company/restore/{id}', [CompanyController::class, 'restore'])->name('company.restore');



});


require __DIR__.'/auth.php';
