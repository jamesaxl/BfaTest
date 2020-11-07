<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpiIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('sector_id')->nullable();
            $table->string('key_word')->nullable();

            $table->foreign('country_id')->references('id')->on('sectors')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('sector_id')->references('id')->on('sectors')
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
        Schema::dropIfExists('kpi_indicators');
    }
}
