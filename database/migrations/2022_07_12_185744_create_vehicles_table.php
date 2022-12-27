<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->unsignedBigInteger('driver_bank_id');
            $table->tinyInteger('status')->comment('REGULAR, EM ANALISE, IRREGULAR');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('version')->nullable();
            $table->string('manufacture_date')->nullable();
            $table->string('licence_plate')->unique();
            $table->string('licence_number')->comment('Registro Nacional de Veículos Automotores (RENAVAM)')->nullable();
            $table->string('antt')->nullable();
            $table->string('uf')->nullable();
            $table->string('document_url')->nullable();
            $table->string('document_path')->nullable();
            $table->string('owner_document')->nullable();
            $table->string('owner_type')->nullable()->comment('Pessoa Jurídica(PJ) if document_1 > 11 | Pessoa Física(PF) ');
            $table->string('owner_name')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('owner_birthday')->nullable()->comment('Pessoa Jurídica(PJ) if document_1 > 11 | Pessoa Física(PF) ');
            $table->string('owner_mother_name')->nullable();
            $table->string('owner_rg')->nullable();
            $table->string('owner_rg_uf')->nullable();
            $table->string('owner_rg_issue')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types');
            $table->foreign('driver_bank_id')->references('id')->on('driver_banks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
