<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('photo_path')->nullable();
            $table->string('abv_gender')->nullable();
            $table->string('politeness_formula')->nullable();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('nationality_id')->nullable();
            $table->string('company')->nullable();
            $table->foreignId('account_type_id')->nullable();
            $table->foreignId('account_sub_type_id')->nullable();
            $table->string('job_title')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('website')->nullable();
            $table->string('cv')->nullable();
            $table->longText('biography')->nullable();
            $table->enum('status', array('public', 'confidential'))->nullable();
            $table->enum('valid', array('yes', 'no'))->nullable();
            $table->foreignId('language_id')->nullable();

            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('account_type_id')->references('id')->on('account_types');
            $table->foreign('account_sub_type_id')->references('id')->on('account_sub_types');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('nationality_id')->references('id')->on('countries');
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
        Schema::dropIfExists('contacts');
    }
}
