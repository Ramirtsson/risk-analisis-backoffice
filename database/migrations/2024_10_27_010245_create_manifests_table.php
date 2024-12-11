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
        Schema::create('manifests', function (Blueprint $table) {
            $table->id();
            $table->string('import_request', 20)->comment('pedimento');
            $table->date('arrival_date')->comment('fecha de arrivo');
            $table->date('modulation_date')->comment('fecha de modulacion');
            $table->string('number_guide',100)->comment('numero de guia');
            $table->string('house_guide',100)->comment('guia house');
            $table->decimal('lumps',6, 3)->comment('bultos');
            $table->decimal('gross_weight',6, 3)->comment('peso bruto');
            $table->integer('packages')->comment('número de paquetes');
            $table->integer('registration_number')->comment('número de registro');
            $table->string('invoice')->comment('número de factura');
            $table->date('invoice_date')->comment('fecha de factura');
            $table->boolean('rectified')->default(false)->comment('manifiesto rectificado');
            $table->string('total_invoice',10)->comment('total de factura');
            $table->date('transmission_date')->comment('fecha de transmision');
            $table->date('payment_date')->comment('fecha de pago');
            $table->string('manifest_file')->nullable()->comment('archivo de manifiesto');
            $table->boolean('checked')->default(false)->comment('manifiesto verificado');

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->on('customers')->references('id');

            $table->unsignedBigInteger('custom_agent_id');
            $table->foreign('custom_agent_id')->on('customs_agents')->references('id');

            $table->unsignedBigInteger('custom_house_id');
            $table->foreign('custom_house_id')->on('custom_houses')->references('id');

            $table->unsignedBigInteger('courier_company_id');
            $table->foreign('courier_company_id')->on('courier_companies')->references('id');

            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->on('suppliers')->references('id');

            $table->unsignedBigInteger('traffic_id');
            $table->foreign('traffic_id')->on('traficcs')->references('id');

            $table->unsignedBigInteger('value_id');
            $table->foreign('value_id')->on('value_types')->references('id');

            $table->unsignedBigInteger('exchange_rate_id');
            $table->foreign('exchange_rate_id')->on('exchange_rates')->references('id');

            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->on('currencies')->references('id');

            $table->unsignedBigInteger('warehouse_office_id');
            $table->foreign('warehouse_office_id')->on('warehouse_offices')->references('id');

            $table->unsignedBigInteger('warehouse_origin_id');
            $table->foreign('warehouse_origin_id')->on('warehouses_origin')->references('id');

            $table->unsignedBigInteger('operating_status_id');
            $table->foreign('operating_status_id')->on('operating_statuses')->references('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id');

            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->on('statuses')->references('id');

            $table->comment('manifiestos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manifests');
    }
};
