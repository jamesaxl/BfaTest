<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('photo_path')->nullable();
            $table->enum('abv_gender', ['Mr.', 'Mrs.', 'Ms.'])->nullable();
            $table->string('politeness_formula')->nullable();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('gender', array('male', 'female'));
            $table->foreignId('country_id')->nullable();
            $table->foreignId('nationality_id')->nullable();
            $table->foreignId('account_type_id')->nullable();
            $table->foreignId('account_sub_type_id')->nullable();

            $table->string('job_title')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('personal_email')->unique()->nullable();
            $table->Text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('website')->nullable();
            $table->Text('biography')->nullable();
            $table->string('cv')->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->foreignId('role_id')->nullable();
            $table->boolean('is_focal')->default(false);
            $table->boolean('is_expert')->default(false);
            $table->boolean('is_logistician')->default(false);
            $table->foreignId('language_id')->nullable();
            $table->foreignId('organization_id')->nullable();

            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('account_type_id')->references('id')->on('account_types');
            $table->foreign('account_sub_type_id')->references('id')->on('account_sub_types');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('nationality_id')->references('id')->on('countries');
            $table->foreign('role_id')->references('id')->on('roles');


            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
