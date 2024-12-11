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
        Schema::create('manifest_contents', function (Blueprint $table) {
            $table->id();
            $table->string('mwb');
            $table->string('tracking_number',50);
            $table->string('consignee');
            $table->string('cnne_address',500);
            $table->string('zip_code', 10);
            $table->string('cnne_city_name');
            $table->string('cnne_state', 100);
            $table->string('phone', 20);
            $table->string('parcel_weight', 10);
            $table->string('total_declared', 10);
            $table->text('product_description');
            $table->string('email');
            $table->string('consignee_rfc', 20);
            $table->string('consignee_curp', 50);
            $table->string('shipper');
            $table->text('shipper_address');
            $table->string('shipper_phone', 20);
            $table->string('shipper_mail',100);
            $table->unsignedBigInteger('manifest_id');
            $table->foreign('manifest_id')->references('id')->on('manifests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manifest_contents');
    }
};
