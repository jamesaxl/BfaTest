<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGovernmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE TABLE governments
(
    id SERIAL PRIMARY KEY NOT NULL,
    country_info text COLLATE pg_catalog."default",
    president_minister character varying(255) COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('governments');
    }
}
