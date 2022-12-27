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
        Schema::create('driver_partners', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->string('name');
            $table->string('email');
            $table->boolean('status')->default(0)->comment('0 Refused - 1  Accpet -  2 Pending - 3 Checking ');
            $table->dateTime('accepted_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_partners');
    }
};
