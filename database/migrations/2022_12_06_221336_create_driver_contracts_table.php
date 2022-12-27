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
        Schema::create('driver_contracts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('risk_manager_session_id');
            $table->unsignedBigInteger('driver_partner_id');
            $table->string('external_id')->nullable();
            $table->string('ref')->nullable();
            $table->string('status');
            $table->dateTime('issue_date')->nullable();
            $table->dateTime('expire_at')->nullable();

            $table->string('requester_name');
            $table->string('requester_email');
            $table->string('requester_phone');
            $table->string('requester_document');

            $table->string('driver_name');
            $table->string('driver_email');
            $table->string('driver_phone')->nullable();
            $table->string('driver_document_1')->nullable();
            $table->string('driver_gender')->nullable();
            $table->date('driver_birthday')->nullable();
            $table->string('driver_address')->nullable();
            $table->string('driver_zipcode')->nullable();

            $table->string('driver_licence_number');
            $table->string('driver_licence_security_code');
            $table->date('driver_licence_expire_at');
            $table->date('driver_licence_first_licence_date');
            $table->string('driver_licence_uf');
            $table->string('driver_licence_mother_name');

            $table->string('vehicle_brand')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_version')->nullable();
            $table->string('vehicle_licence_plate');
            $table->string('vehicle_licence_number')->comment('Registro Nacional de Veículos Automotores (RENAVAM)')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('driver_partner_id')->references('id')->on('driver_partners')->onDelete('cascade');
            $table->foreign('risk_manager_session_id')->references('id')->on('risk_manager_sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_contracts');
    }
};
