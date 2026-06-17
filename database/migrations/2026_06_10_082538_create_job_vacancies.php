<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->mediumText('description');
            $table->string('location');
            $table->string('salary');
            $table->enum('type', ['Full-Time', 'Contract', 'Hybrid', 'Remote'])->default('Full-Time');
            $table->string('required_skills');
            $table->integer('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('restrict');

            $table->uuid('job_category_id');
            $table->foreign('job_category_id')->references('id')->on('job_categories')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
