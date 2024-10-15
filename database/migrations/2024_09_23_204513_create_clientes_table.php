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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            $table->string('nm_cliente');
            $table->string('tp_cliente')->nullable();
            $table->string('nr_cpf')->nullable();
            $table->string('ds_email')->nullable();
            $table->string('ds_senha')->nullable();
            $table->string('nr_tel')->nullable();
            $table->string('nr_cel')->nullable();
            $table->text('ds_endereco')->nullable();
            $table->text('nr_endereco')->nullable();
            $table->text('ds_complemento')->nullable();
            $table->string('ds_bairro')->nullable();
            $table->string('nm_cidade')->nullable();
            $table->string('ds_uf')->nullable();
            $table->string('nr_cep')->nullable();
            $table->string('custon_id_asaas')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
