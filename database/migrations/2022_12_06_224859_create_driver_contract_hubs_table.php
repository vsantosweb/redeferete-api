<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_contract_hubs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_contract_id');
            $table->foreignId('company_hub_id');
            $table->date('approval_date')->nullable();
            $table->integer('distance')->nullable();
            $table->string('company')->nullable();
            $table->timestamps();

            $table->foreign('driver_contract_id')->references('id')->on('driver_contracts')->onDelete('cascade');
            $table->foreign('company_hub_id')->references('id')->on('company_hubs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_contract_hubs');
    }
};
