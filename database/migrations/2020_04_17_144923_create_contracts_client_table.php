<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts_client', function (Blueprint $table) {
            $table->id();
            
            

           $table->string('name'); 
           $table->string('customer'); 
           $table->string('region_concerned'); 
           $table->string('agreement_summary'); 
           $table->string('acquisition_category'); 
           $table->string('business_amount_euro'); 
           $table->string('contract_amount_euro'); 
           $table->string('total_percent'); 
           $table->string('advance_percent'); 
           $table->string('auction_percent'); 
           $table->string('signature_percent'); 
           $table->string('first disbursement_percent'); 
           $table->string('Second disbursement (%)'); 
           $table->string('deliverable1'); 
           $table->string('deliverable2'); 
           $table->string('deliverable3'); 
           $table->string('deliverable4'); 
           $table->string('total_deliverables_euro'); 
           $table->string('deliverable1_percent'); 
           $table->string('deliverable2_percent'); 
           $table->string('deliverable3_percent'); 
           $table->string('deliverable4_percent'); 

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
        Schema::dropIfExists('contracts_client');
    }
}
