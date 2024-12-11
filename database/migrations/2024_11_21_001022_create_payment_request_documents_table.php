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
        Schema::create('payment_request_documents', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('file_name');
            $table->unsignedBigInteger('file_type_id');
            $table->foreign('file_type_id')->references('id')->on('file_types');
            $table->unsignedBigInteger('payment_request_id');
            $table->foreign('payment_request_id')->references('id')->on('payment_requests');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_request_documents');
    }
};
