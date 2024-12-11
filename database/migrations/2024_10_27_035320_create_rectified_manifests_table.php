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
        Schema::create('rectified_manifests', function (Blueprint $table) {
            $table->id();
            $table->string('number_rectified');
            $table->date('payment_date');
            $table->date('modulation_date');
            $table->unsignedBigInteger('manifest_id');
            $table->foreign('manifest_id')->on('manifests')->references('id');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->on('statuses')->references('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rectified_manifests');
    }
};
