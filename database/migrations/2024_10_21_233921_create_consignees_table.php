<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consignees', function (Blueprint $table) {
            $table->id();
            $table->string('name',80);
            $table->string('rfc',13);
            $table->string('curp',13);
            $table->string('address',13);
            $table->string('city',200);
            $table->string('email',50);
            $table->string('phone',50);
            $table->string('zip_code',10);
            $table->string('state',6);
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consignees');
    }
};
