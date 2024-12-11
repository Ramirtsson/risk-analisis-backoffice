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
        Schema::create('manifest_files', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('path');
            $table->unsignedBigInteger('manifest_id');
            $table->foreign('manifest_id')->on('manifests')->references('id');
            $table->unsignedBigInteger('type_manifest_document_id');
            $table->foreign('type_manifest_document_id')->on('type_manifest_documents')->references('id');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->on('statuses')->references('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->comment('documentos de manifiestos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manifest_files');
    }
};
