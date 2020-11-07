<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE TABLE public.transporters
(
    id SERIAL PRIMARY KEY NOT NULL,
    transport_mode character varying(255) COLLATE pg_catalog."default",
    transport_equipment_number integer,
    annual_turnover character varying(255) COLLATE pg_catalog."default",
    employees_number integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
        organization_id bigint,
    CONSTRAINT organizations_id_foreign FOREIGN KEY (organization_id)
    REFERENCES public.organizations (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE
);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transporters');
    }
}
