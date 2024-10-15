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
        Schema::create('projeto_boletos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('projeto_id');
            $table->unsignedBigInteger('cliente_id');
            $table->integer('nr_boleto');
            $table->date('dt_boleto');
            $table->double('vl_boleto',10,2);
            $table->string('st_boleto');
            $table->text('link_boleto')->nullable();
            $table->string('id_pagamento')->nullable();
            $table->string('arquivo_comprovante')->nullable();
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
        Schema::dropIfExists('projeto_boletos');
    }
};
