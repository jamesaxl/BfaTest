<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_sectors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->nullable();
            $table->foreignId('sector_id')->nullable();

            $table->foreign('contact_id')->references('id')->on('contacts')
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
        Schema::dropIfExists('contact_sectors');
    }
}
