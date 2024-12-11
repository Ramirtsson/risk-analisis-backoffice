<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_type');
            $table->string('social_reason', 70);
            $table->string('tax_domicile', 300);
            $table->string('tax_id', 25);
            $table->string('phone_1', 15)->nullable();
            $table->string('phone_2', 15)->nullable();
            $table->string('mail_1', 50)->nullable();
            $table->string('mail_2', 50)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('status_id');
        
            $table->foreign('customer_type')->references('id')->on('client_types');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('statuses');
        
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
