<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();

            $table->string('hash')->unique()->nullable();
            $table->foreignId('add_by_id')->nullable();
            $table->foreignId('continent_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->foreignId('project_id')->nullable();
            $table->foreignId('sector_id')->nullable();
            $table->foreignId('producer_id')->nullable();
            $table->longText('acquisition_title')->nullable();
            $table->enum('acquisition_type', ['current', 'future'])->nullable();
            $table->string('geo_location')->nullable();
            $table->date('date_event')->nullable(); // check websites that are used by scraper
            $table->string('ref')->nullable();
            $table->string('executing_agency')->nullable();
            $table->string('executing_agency_email')->nullable();
            $table->string('executing_agency_phone')->nullable();
            $table->string('executing_agency_address')->nullable();
            $table->longText('acquisition_link')->nullable();
            $table->enum('category_acquisition', ['works', 'goods', 'services',])->nullable();
            $table->enum('document_type',
                         [
                             'general procurement notice',
                             'invitation for bids',
                             'invitation for pre-qualification',
                             'request for expression of interest',
                             'contracts o-ward',
                         ])->nullable();
            $table->longText('acquisition_description')->nullable();
            $table->longText('acquisition_information')->nullable();
            $table->string('progress')->nullable();
            $table->enum('selection_mode',
                         [
                             'AOI',
                             'AON',
                             'AOO',
                             'SBQC',
                             'SMC',
                             'SED',
                         ])->nullable();

            $table->enum('ftq',
                [
                    'flat rate',
                    'time spent',
                    'quantity',
                ])->nullable();
            $table->date('publication_date')->nullable();
            $table->date('estimated_date_event_delivery')->nullable();
            $table->date('estimated_date_event_discount')->nullable();
            $table->string('lot_number')->nullable();
            $table->string('estimated_amount_currency')->nullable();
            $table->string('euro_exchange_rate')->nullable();
            $table->string('estimated_amount_euro')->nullable();
            $table->date('date_sign_contract')->nullable();
            $table->date('start_date')->nullable();
            $table->date('submission_date')->nullable();
            $table->string('country_decision_maker_name')->nullable();
            $table->string('task_manager_name')->nullable();
            $table->enum('status',
                         [
                             'selected by the client',
                             'general procurement notice',
                             'pre-qualification',
                             'launch call for tenders',
                             'submission of tenders',
                             'opening of tenders',
                             'date receipt of DAO',
                             'analysis of tenders',
                             'non-objection from donors',
                             'award contract signature',
                             'contract start order',
                             'submission date',
                         ])->nullable();
            $table->string('document_path')->nullable();
            $table->string('document_extension')->nullable();
            $table->boolean('is_enabled')->default(false);

            $table->foreign('add_by_id')->references('id')->on('users');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->foreign('producer_id')->references('id')->on('producers');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('continent_id')->references('id')->on('continents');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');

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
        Schema::dropIfExists('opportunities');
    }
}
