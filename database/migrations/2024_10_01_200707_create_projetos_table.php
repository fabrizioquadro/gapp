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
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orcamento_id');
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('cliente_id');
            $table->string('nm_projeto');
            $table->text('ds_projeto')->nullable();
            $table->date('dt_contratacao');
            $table->double('vl_projeto',10,2);
            $table->string('ds_forma_pagamento');
            $table->text('obs_forma_pagamento');
            $table->string('ip_contratante')->nullable();
            $table->text('caminho_contrato_pdf')->nullable();
            $table->string('st_projeto')->default('Aberto');
            $table->foreign('orcamento_id')->references('id')->on('orcamentos');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projetos');
    }
};
