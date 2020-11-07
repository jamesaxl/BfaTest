<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DB::statement('CREATE TABLE companies
//(created_at timestamp(0) without time zone,
//updated_at timestamp(0) without time zone)
//INHERITS (organizations);');

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id');
            $table->foreign('organization_id')->references('id')
                ->on('organizations')
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
        Schema::dropIfExists('companies');
    }
}
