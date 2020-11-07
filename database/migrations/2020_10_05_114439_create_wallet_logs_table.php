<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('wallet_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('organization_id')->nullable();
            $table->enum('action', ['debit', 'credit'])->nullable();
            $table->double('amount');
            $table->Text('description');

            $table->foreign('wallet_id')->references('id')->on('wallets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->foreign('organization_id')->references('id')->on('users')
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
        Schema::dropIfExists('wallet_logs');
    }
}
