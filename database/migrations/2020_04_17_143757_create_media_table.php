<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('photo_path')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('organization')->nullable();
            $table->string('position_in_organisation')->nullable();

            $table->foreignId('nationality_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->enum('language', array('english', 'french', 'bilingual'))->nullable();
            $table->string('category')->nullable();
            $table->string('category_code')->nullable();
            $table->string('first_level_category')->nullable();
            $table->string('reg_status')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('role')->nullable();
            $table->enum('status', array('active', 'blacklist'))->nullable();
            $table->foreignId('sector_id')->nullable();


            $table->foreign('nationality_id')->references('id')->on('countries');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');

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
        Schema::dropIfExists('media');
    }
}
