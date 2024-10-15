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
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('cliente_id');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->integer('validade')->nullable();
            $table->string('st_orcamento')->nullable();
            $table->integer('desconto_avista')->nullable();
            $table->integer('parcelamento_cartao')->nullable();
            $table->integer('parcelamento_entrada')->nullable();
            $table->date('vencimento_entrada')->nullable();
            $table->integer('parcelamento_vezes')->nullable();
            $table->integer('entrega_entrada')->nullable();
            $table->date('entrega_vencimento')->nullable();
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
        Schema::dropIfExists('orcamentos');
    }
};
