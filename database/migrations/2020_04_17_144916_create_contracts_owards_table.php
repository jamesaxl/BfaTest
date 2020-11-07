<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsOwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts_owards', function (Blueprint $table) {
            $table->id();
                        
            $table->string('organization');
            $table->string('project_definition');
            $table->string('description_project');
            $table->string('currency');
            $table->string('contract_title');
            $table->string('company_name');
            $table->string('country');
            $table->string('total_contract_amount_uac');
            $table->string('procurement_mode');
            $table->string('country_key');
            $table->string('project_country');
            $table->string('nationality');
            $table->string('contract_duration');
            $table->string('duration_int_meas_unit');
            $table->string('regional_prerefence');
            $table->string('contract_signature_date');
            $table->string('total_number_bids_received_for_package');
            $table->string('country_contract_reference');
            $table->string('goods_or_services_origin');
            $table->string('expense_category');
            $table->string('fullname');
            $table->string('address');
            $table->string('email');
            $table->string('phone');
            $table->string('submissioner_1');
            $table->string('offre_amount_1');
            $table->string('submissioner_2');
            $table->string('offre_amount_2');
            $table->string('submissioner_3');
            $table->string('offre_amount_3');
            $table->string('submissioner_4');
            $table->string('offre_amount_4');
            
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
        Schema::dropIfExists('contracts_owards');
    }
}
