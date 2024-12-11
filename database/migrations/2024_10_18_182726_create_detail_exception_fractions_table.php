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
        Schema::create('detail_exception_fractions', function (Blueprint $table) {
            $table->unsignedBigInteger('detail_fraction_id');
            $table->foreign('detail_fraction_id')->references('id')->on('detail_fractions');
            $table->unsignedBigInteger('exception_id');
            $table->foreign('exception_id')->references('id')->on('exceptions');
            $table->unsignedBigInteger('fraction_id');
            $table->foreign('fraction_id')->references('id')->on('fractions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_exception_fractions');
    }
};
