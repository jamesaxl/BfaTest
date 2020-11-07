<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('person');
            $table->string('ressource');
            $table->string('institution');
            $table->string('report_date');
            $table->string('report_number');
            $table->string('report_type');
            $table->string('report_title');
            $table->string('lesson');
            $table->string('country');
            $table->string('sub_sectors');
            $table->string('themes');
            $table->string('project_steps_cycle');
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
        Schema::dropIfExists('lessons');
    }
}
