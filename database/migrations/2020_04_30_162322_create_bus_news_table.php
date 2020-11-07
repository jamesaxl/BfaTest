<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('publication_date');
            $table->text('description');
            $table->string('type');	
            $table->string('country');
            $table->string('sector');
            $table->string('sub_sector');
            $table->string('project');
            $table->string('key_words');
            $table->string('file');
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
        Schema::dropIfExists('bus_news');
    }
}
