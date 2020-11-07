<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('video_url')->nullable();
            $table->string('title')->nullable();
            $table->enum('type', [ 'photo', 'video', 'text' ])->nullable();
            $table->string('project_initiative')->nullable();
            $table->string('donor')->nullable();
            $table->string('key_words')->nullable();
            $table->foreignId('country_id')->nullable()->nullable();
            $table->foreignId('sector_id')->nullable()->nullable();
            $table->foreignId('sub_sector_id')->nullable()->nullable();
            $table->enum('valid', ['yes', 'no'])->nullable()->nullable();
            $table->Text('description')->nullable();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->foreign('sub_sector_id')->references('id')->on('sub_sectors');
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
        Schema::dropIfExists('videos');
    }
}
