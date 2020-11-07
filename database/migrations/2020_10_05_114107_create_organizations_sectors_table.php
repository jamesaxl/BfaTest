<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations_sectors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sector_id')->nullable();
            $table->foreignId('organization_id')->nullable();

            $table->foreign('sector_id')->references('id')->on('sectors')
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
        Schema::dropIfExists('organizations_sectors');
    }
}
