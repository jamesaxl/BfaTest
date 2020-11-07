<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_answers', function (Blueprint $table) {
            $table->id();
            $table->longText('paragraph')->nullable();
            $table->Text('question')->nullable();
            $table->Text('answer')->nullable();
            $table->string('resource')->nullable();
            $table->string('institution')->nullable();
            $table->date('answer_date')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('sector_id')->nullable();
            $table->foreignId('sub_sector_id')->nullable();
            $table->string('theme')->nullable();
            $table->foreignId('document_type_id')->nullable();
            $table->string('document')->nullable();
            $table->foreignId('producer_id')->nullable();
            $table->foreignId('destination_id')->nullable();
            $table->enum('status', ['public', 'private'])->default('public');

            $table->foreign('document_type_id')->references('id')->on('document_types');
            $table->foreign('producer_id')->references('id')->on('users');
            $table->foreign('destination_id')->references('id')->on('users');
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
        Schema::dropIfExists('questions_answers');
    }
}
