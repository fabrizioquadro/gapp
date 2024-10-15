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
        Schema::create('empresa_configuracaos', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id')->primary();
            $table->text('asaas_client')->nullable();
            $table->string('asaas_method')->nullable();
            $table->string('tipo_pix')->nullable();
            $table->string('chave_pix')->nullable();
            $table->text('modelo_contrato')->nullable();
            $table->text('modelo_contrato_anexo')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_configuracaos');
    }
};
