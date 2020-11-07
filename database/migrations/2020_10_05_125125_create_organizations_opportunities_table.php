<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations_opportunities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('opportunity_id')->nullable();
            $table->foreignId('organization_id')->nullable();

            $table->foreign('opportunity_id')->references('id')->on('opportunities')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('organization_id')->references('id')->on('organizations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('organizations_opportunities');
    }
}
