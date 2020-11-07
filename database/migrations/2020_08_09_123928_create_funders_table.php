<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE TABLE public.funders
(
    id SERIAL PRIMARY KEY NOT NULL,
    employees_number character varying(255) COLLATE pg_catalog."default",
    available_amount character varying(255) COLLATE pg_catalog."default",
    funds_sources character varying(255) COLLATE pg_catalog."default",
    type character varying(255) COLLATE pg_catalog."default",
    sub_type character varying(255) COLLATE pg_catalog."default",
    fund_manager character varying(255) COLLATE pg_catalog."default",
    fund_nature character varying(255) COLLATE pg_catalog."default",
    sustainability character varying(255) COLLATE pg_catalog."default",
    adaptation character varying(255) COLLATE pg_catalog."default",
    recipients_type character varying(255) COLLATE pg_catalog."default",
    eligibility_criteria character varying(255) COLLATE pg_catalog."default",
    decision_making_information character varying(255) COLLATE pg_catalog."default",
    financial_instrument character varying(255) COLLATE pg_catalog."default",
    monitoring character varying(255) COLLATE pg_catalog."default",
    application_timeframe character varying(255) COLLATE pg_catalog."default",
    key_inputs_required_throughout_the_process character varying(255) COLLATE pg_catalog."default",
    further_application_support_sources character varying(255) COLLATE pg_catalog."default",
    recent_funded_projects_examples character varying(255) COLLATE pg_catalog."default",
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
        Schema::dropIfExists('funders');
    }
}
