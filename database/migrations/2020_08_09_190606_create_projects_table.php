<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('hash')->unique()->nullable();
            $table->string('project_link')->unique()->nullable();
            $table->foreignId('add_by_id')->nullable();
            $table->foreignId('continent_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->string('region')->nullable();
            $table->foreignId('sector_id')->nullable();
            $table->foreignId('sub_sector_id')->nullable();
            $table->string('donor')->nullable();
            $table->string('name')->nullable();
            $table->string('analytic_summary')->nullable();
            $table->string('acquisition_summary_modalities')->nullable();
            $table->string('risks_related_to_acquisitions')->nullable();
            $table->string('sector_market_analysis')->nullable();
            $table->Text('progress')->nullable();
            $table->string('executing_agency')->nullable();
            $table->string('boss_name')->nullable();
            $table->string('executing_agency_email')->unique()->nullable();
            $table->string('executing_agency_phone')->nullable();
            $table->string('website')->nullable();
            $table->string('decision_maker_name_in_country')->nullable();
            $table->string('email_decision_maker')->unique()->nullable();
            $table->string('phone_decision_maker')->unique()->nullable();
            $table->string('division_in_charge_of_the_project_at_the_donor')->nullable();
            $table->enum('project_status', ['identified', 'approved', 'in progress',
                                            'completed', 'canceled'])->nullable();
            $table->date('approval_date')->nullable();
            $table->string('effective_first_disbursement')->nullable();
            $table->string('actual_first_disbursement')->nullable();
            $table->string('latest_disbursement')->nullable();
            $table->date('planned_project_completion_date')->nullable();
            $table->date('original_closing_date')->nullable();
            $table->date('planned_final_disbursement_date')->nullable();
            $table->string('disbursement_ratio')->nullable();
            $table->string('amount_not_disbursed')->nullable();
            $table->string('task_manager_name')->nullable();
            $table->string('task_manager_email')->nullable();
            $table->string('window_funds')->nullable();
            $table->string('amount')->nullable();

            $table->foreignId('currency_id')->nullable();

            $table->string('loan_number')->nullable();
            $table->string('entry_into_force')->nullable();
            $table->string('total_undisb')->nullable();
            $table->string('rd_regional_dept')->nullable();
            $table->date('loans_exchange_rate_date')->nullable();
            $table->string('sector_dept')->nullable();
            $table->string('project_age_in_years')->nullable();
            $table->string('par_report')->nullable();
            $table->string('annex')->nullable();
            $table->string('ppm')->nullable();
            $table->string('file')->nullable();
            $table->string('project_geo')->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->string('exchange_rate')->nullable();
            $table->date('date_event')->nullable(); // check websites that are used by scraper

            $table->foreign('add_by_id')->references('id')->on('users');
            $table->foreign('continent_id')->references('id')->on('continents');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->foreign('sub_sector_id')->references('id')->on('sub_sectors');
            $table->foreign('currency_id')->references('id')->on('currencies');

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
        Schema::dropIfExists('projects');
    }
}
