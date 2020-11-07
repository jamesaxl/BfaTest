<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();

            $table->string('photo_path')->nullable();
            $table->string('name')->unique()->nullable();
            $table->foreignId('organization_type_id')->nullable();
            $table->foreignId('organization_sub_type_id')->nullable();
            $table->enum('evaluation', array(1, 2, 3, 4, 5))->nullable();
            $table->foreignId('continent_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('nationality_id')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->Text('preview')->nullable();
            $table->Text('biography')->nullable();
            $table->enum('status', array('active', 'blacklist'))->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->foreignId('language_id')->nullable();
            $table->foreignId('currency_id')->nullable();

            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('organization_type_id')->references('id')->on('account_types');
            $table->foreign('organization_sub_type_id')->references('id')->on('account_sub_types');
            $table->foreign('continent_id')->references('id')->on('continents');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('nationality_id')->references('id')->on('countries');
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
        Schema::dropIfExists('organizations');
    }
}
