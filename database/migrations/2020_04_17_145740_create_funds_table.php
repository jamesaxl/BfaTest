<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funds', function (Blueprint $table) {
            $table->id();
            $table->string('fund_name')->nullable();
            $table->string('intervention_sectors')->nullable();
            $table->string('available_amount')->nullable();
            $table->string('source')->nullable();
            $table->string('type')->nullable();
            $table->string('sub_type')->nullable();
            $table->string('fund_manager')->nullable();
            $table->string('fund_nature')->nullable();
            $table->string('sustainability')->nullable();
            $table->string('adaptation_mitigation_bias')->nullable();
            $table->string('recipients_type')->nullable();
            $table->string('decision_making_information')->nullable();
            $table->string('financial_instrument')->nullable();
            $table->string('monitoring_reporting_procedures')->nullable(); // table
            $table->string('eligibility_criteria')->nullable();
            $table->string('application_time_frame')->nullable();
            $table->string('key_inputs_required_throughout_the_process')->nullable();
            $table->string('further_application_support_sources')->nullable(); // table
            $table->string('recent_funded_projects_examples')->nullable(); // table
            $table->string('website')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('funds');
    }
}
