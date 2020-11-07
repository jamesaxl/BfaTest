<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE TABLE public.insurances
(
    id SERIAL PRIMARY KEY NOT NULL,
    mother_group character varying(255) COLLATE pg_catalog."default",
    intervention_industries character varying(255) COLLATE pg_catalog."default",
    employees_number character varying(255) COLLATE pg_catalog."default",
    assets character varying(255) COLLATE pg_catalog."default",
    revenue character varying(255) COLLATE pg_catalog."default",
    net_premium_writen character varying(255) COLLATE pg_catalog."default",
    market_cap character varying(255) COLLATE pg_catalog."default",
    pe_ratio character varying(255) COLLATE pg_catalog."default",
    president_name character varying(255) COLLATE pg_catalog."default",
    agency_boss character varying(255) COLLATE pg_catalog."default",
    document character varying(255) COLLATE pg_catalog."default",
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
        Schema::dropIfExists('insurances');
    }
}
