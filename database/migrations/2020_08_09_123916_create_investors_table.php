<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE TABLE public.investors
(
    id SERIAL PRIMARY KEY NOT NULL,
    fund_size character varying(255) COLLATE pg_catalog."default",
    number_employees character varying(255) COLLATE pg_catalog."default",
    recent_funded_projects_examples character varying(255) COLLATE pg_catalog."default",
    fund_manager_trustee character varying(255) COLLATE pg_catalog."default",
    amount_available character varying(255) COLLATE pg_catalog."default",
    type_recipients character varying(255) COLLATE pg_catalog."default",
    eligibility_criteria character varying(255) COLLATE pg_catalog."default",
    decision_making character varying(255) COLLATE pg_catalog."default",
    information character varying(255) COLLATE pg_catalog."default",
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
        Schema::dropIfExists('investors');
    }
}
