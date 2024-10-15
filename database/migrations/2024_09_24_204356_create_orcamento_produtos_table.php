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
        Schema::create('orcamento_produtos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orcamento_id');
            $table->string('nm_produto');
            $table->text('ds_produto')->nullable();
            $table->double('vl_produto',10,2);
            $table->integer('dias_entrega');
            $table->string('st_produto');
            $table->foreign('orcamento_id')->references('id')->on('orcamentos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamento_produtos');
    }
};
