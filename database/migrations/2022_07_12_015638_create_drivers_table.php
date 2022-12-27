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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('driver_status_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('document_1')->nullable();
            $table->string('document_2')->nullable();
            $table->string('type')->nullable()->comment('Pessoa Jurídica(PJ) if document_1 > 11 | Pessoa Física(PF) ');
            $table->string('rg')->nullable();
            $table->string('rg_uf')->nullable();
            $table->date('rg_issue')->nullable();
            $table->string('gender')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('notify')->default(0);
            $table->boolean('newsletter')->default(0);
            $table->boolean('register_complete')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->string('home_dir')->nullable();
            $table->boolean('first_time')->default(1);
            $table->boolean('accepted_terms')->default(0);
            $table->string('user_agent')->nullable();
            $table->string('ip')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('driver_status_id')->references('id')->on('driver_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
};
