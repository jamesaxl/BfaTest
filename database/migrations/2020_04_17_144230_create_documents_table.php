<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('reference')->nullable();
            $table->string('institution')->nullable();
            $table->string('document_path')->nullable();
            $table->foreignId('document_type_id')->nullable();
            $table->foreignId('document_sub_type_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('sector_id')->nullable();
            $table->foreignId('sub_sector_id')->nullable();
            $table->string('key_words')->nullable();
            $table->string('file')->nullable();
            $table->Text('file_transcript')->nullable();

            $table->foreign('document_type_id')->references('id')->on('document_types');
            $table->foreign('document_sub_type_id')->references('id')->on('document_sub_types');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('sub_sector_id')->references('id')->on('sub_sectors');
            $table->foreign('sector_id')->references('id')->on('sectors');

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
        Schema::dropIfExists('documents');
    }
}
