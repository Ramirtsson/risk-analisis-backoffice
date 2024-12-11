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
        Schema::create('custom_agent_custom_houses', function (Blueprint $table) {
            $table->unsignedBigInteger('custom_agent_id');
            $table->foreign('custom_agent_id')->references('id')->on('customs_agents');
            $table->unsignedBigInteger('custom_house_id');
            $table->foreign('custom_house_id')->references('id')->on('custom_houses');
            $table->boolean('checked')->default(false);
            $table->comment('Tabla unos a muchos agente aduanal con muchas aduanas.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_agent_custom_houses');
    }
};
