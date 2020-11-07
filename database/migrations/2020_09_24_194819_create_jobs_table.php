<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            $table->string('job_title')->nullable();
            $table->bigInteger('organization')->nullable();
            $table->foreignId('sector_id')->nullable();
            $table->string('type')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->string('experience')->nullable();
            $table->foreignId('apply_by_id')->nullable();
            $table->string('web_link')->nullable();

            $table->foreign('apply_by_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('sector_id')->references('id')->on('sectors')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('country_id')->references('id')->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
