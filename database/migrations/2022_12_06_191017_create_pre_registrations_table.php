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
        Schema::create('pre_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('licence_plate')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();
            $table->string('hub')->nullable();
            $table->string('code')->nullable();
            $table->string('company')->nullable();
            $table->string('distance')->nullable();
            $table->boolean('is_avaiable')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_registrations');
    }
};
