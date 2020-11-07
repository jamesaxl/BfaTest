<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE TABLE public.financial_institutions
(
    id SERIAL PRIMARY KEY NOT NULL,
    parent_group character varying(255) COLLATE pg_catalog."default",
    intervention_country character varying(255) COLLATE pg_catalog."default",
    general_overview character varying(255) COLLATE pg_catalog."default",
    bank_scope_latest_accounts_date character varying(255) COLLATE pg_catalog."default",
    equity_usb character varying(255) COLLATE pg_catalog."default",
    assets_total_usd character varying(255) COLLATE pg_catalog."default",
    deposits_short_term_funding_usd character varying(255) COLLATE pg_catalog."default",
    net_income_usd character varying(255) COLLATE pg_catalog."default",
    loan_loss_reserve_gross_loans_percent character varying(255) COLLATE pg_catalog."default",
    total_capital_ratio_percent character varying(255) COLLATE pg_catalog."default",
    net_interest_margin_percent character varying(255) COLLATE pg_catalog."default",
    roaa_percent character varying(255) COLLATE pg_catalog."default",
    roae_percent character varying(255) COLLATE pg_catalog."default",
    cir_percent character varying(255) COLLATE pg_catalog."default",
    net_loans_total_assets_percent character varying(255) COLLATE pg_catalog."default",
    liquid_assets_funding_percent character varying(255) COLLATE pg_catalog."default",
    gross_loans_percent character varying(255) COLLATE pg_catalog."default",
    composite_rating character varying(255) COLLATE pg_catalog."default",
    country_rank_by_assets character varying(255) COLLATE pg_catalog."default",
    branches_number character varying(255) COLLATE pg_catalog."default",
    employees_number character varying(255) COLLATE pg_catalog."default",
    entity_type character varying(255) COLLATE pg_catalog."default",
    fi_grouping character varying(255) COLLATE pg_catalog."default",
    subsidiary_foreign_bank character varying(255) COLLATE pg_catalog."default",
    largest_shareholder character varying(255) COLLATE pg_catalog."default",
    government_majority_owner character varying(255) COLLATE pg_catalog."default",
    afdb_country_classification character varying(255) COLLATE pg_catalog."default",
    fragile_state character varying(255) COLLATE pg_catalog."default",
    afdb_country_risk_rating character varying(255) COLLATE pg_catalog."default",
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
        Schema::dropIfExists('financial_institutions');
    }
}
