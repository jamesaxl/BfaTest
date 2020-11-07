<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactSubSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_sub_sectors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contact_id')->nullable();
            $table->foreignId('sub_sector_id')->nullable();

            $table->foreign('contact_id')->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('sub_sector_id')->references('id')->on('sub_sectors')
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
        Schema::dropIfExists('contact_sub_sectors');
    }
}
