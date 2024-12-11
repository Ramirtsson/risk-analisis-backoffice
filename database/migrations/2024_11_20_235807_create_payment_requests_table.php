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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manifest_id');
            $table->unsignedBigInteger('account_id')->comment('id de movimiento tabla Razon_Pagos en base nexen operaciones');
            $table->unsignedBigInteger('request_type_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('tconcept_id');
            $table->foreign('tconcept_id')->references('id')->on('t_concepts');
            $table->text('observations')->nullable();
            $table->decimal('payment_amount', 10, 2)->comment('importe del pago');
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('manifest_id')->references('id')->on('manifests');
            $table->foreign('request_type_id')->references('id')->on('request_types');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};
