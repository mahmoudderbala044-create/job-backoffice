<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Job_vacancyController;
use App\Http\Controllers\Job_CategoryController;
use App\Http\Controllers\Job_ApplicationController;
use App\Http\Controllers\UserController;

 

// share routs
Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    
    
    Route::resource('job-vacancy', Job_vacancyController::class);
    Route::post('job-vacancy/restore/{id}', [Job_vacancyController::class, 'restore'])->name('job-vacancy.restore');

  
    
    Route::resource('job-application', Job_ApplicationController::class);
    Route::post('job-application/restore/{id}', [Job_ApplicationController::class, 'restore'])->name('job-application.restore');



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

    Route::resource('category', Job_CategoryController::class);
    Route::post('category/restore/{id}', [Job_CategoryController::class, 'restore'])->name('category.restore');

    Route::resource('company', CompanyController::class);
    Route::post('company/restore/{id}', [CompanyController::class, 'restore'])->name('company.restore');



});


require __DIR__.'/auth.php';
