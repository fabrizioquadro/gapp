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
        Schema::create('observacao_arquivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('observacao_id');
            $table->text('nm_arquivo');
            $table->text('ds_caminho');
            $table->foreign('observacao_id')->references('id')->on('observacaos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observacao_arquivos');
    }
};
