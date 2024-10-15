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
        Schema::create('anexo_projeto_arquivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anexo_id');
            $table->string('nm_arquivo');
            $table->string('ds_caminho');
            $table->foreign('anexo_id')->references('id')->on('anexo_projetos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anexo_projeto_arquivos');
    }
};
