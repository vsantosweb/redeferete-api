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
        Schema::create('driver_company_hubs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id');
            $table->foreignId('company_hub_id');
            $table->string('status')->default('EM ANALISE');
            $table->date('approval_date')->nullable();
            $table->integer('distance')->nullable();
            $table->string('company')->nullable();
            $table->timestamps();

            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_company_hubs');
    }
};
