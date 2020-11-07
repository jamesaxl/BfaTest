<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectorInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sector_infos', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable;
            $table->foreignId('country_id')->nullable();
            $table->foreignId('sector_id')->nullable();
            $table->string('sector_overview')->nullable();
            $table->string('main_donors')->nullable();
            $table->string('document')->nullable();

            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->foreign('country_id')->references('id')->on('countries');
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
        Schema::dropIfExists('sector_infos');
    }
}
