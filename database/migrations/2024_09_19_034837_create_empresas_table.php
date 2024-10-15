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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nm_empresa');
            $table->string('tp_empresa');
            $table->string('nr_cnpj')->nullable();
            $table->string('nr_tel')->nullable();
            $table->string('nr_cel')->nullable();
            $table->string('ds_email')->unique();
            $table->string('ds_senha');
            $table->string('nr_cep')->nullable();
            $table->text('ds_endereco')->nullable();
            $table->text('nr_endereco')->nullable();
            $table->text('ds_complemento')->nullable();
            $table->text('ds_bairro')->nullable();
            $table->text('nm_cidade')->nullable();
            $table->text('ds_uf')->nullable();
            $table->text('ds_empresa')->nullable();
            $table->string('st_empresa');
            $table->string('imagem')->nullable();
            $table->date('dt_validade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
