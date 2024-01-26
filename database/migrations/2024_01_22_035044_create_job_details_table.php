<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_details', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('subject');
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->text('education_and_experience')->nullable();
            $table->string('location');
            $table->integer('vacancy_count');
            $table->string('salary')->nullable();
            $table->string('salary_currency')->nullable();
            $table->date('vacancy_end_date')->nullable();
            $table->integer('created_by');
            $table->integer('job_type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_details');
    }
}
