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
        Schema::create('anexo_projetos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('projeto_id');
            $table->unsignedBigInteger('cliente_id');
            $table->string('nm_anexo');
            $table->text('ds_anexo')->nullable();
            $table->date('dt_contratacao')->nullable();
            $table->double('vl_anexo',10,2);
            $table->string('ds_forma_pagamento')->nullable();
            $table->text('obs_forma_pagamento')->nullable();
            $table->string('st_anexo');
            $table->text('caminho_contrato_pdf')->nullable();
            $table->foreign('projeto_id')->references('id')->on('projetos');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anexo_projetos');
    }
};
