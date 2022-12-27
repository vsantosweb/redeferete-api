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
        Schema::create('risk_manager_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_manager_id');
            $table->string('type');
            $table->string('token');
            $table->string('expire_at');
            $table->timestamps();
            $table->foreign('risk_manager_id')->references('id')->on('risk_managers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_manager_sessions');
    }
};
