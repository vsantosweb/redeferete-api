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
        Schema::create('driver_licences', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('driver_licence_category_id');
            $table->unsignedBigInteger('driver_id');
            $table->string('document_number');
            $table->string('security_code');
            $table->date('expire_at');
            $table->date('first_licence_date');
            $table->string('uf');
            $table->string('mother_name');
            $table->tinyInteger('status')->default(0);
            $table->string('document_file')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->foreign('driver_licence_category_id')->references('id')->on('driver_licence_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_licences');
    }
};
