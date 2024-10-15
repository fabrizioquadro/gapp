<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnexoProjeto extends Model
{
    use HasFactory;

    protected $fillable = [
        'projeto_id',
        'cliente_id',
        'nm_anexo',
        'ds_anexo',
        'dt_contratacao',
        'vl_anexo',
        'ds_forma_pagamento',
        'obs_forma_pagamento',
        'st_anexo',
        'caminho_contrato_pdf',
    ];

    public function projeto(){
        return $this->belongsTo(Projeto::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function arquivos(){
        return $this->hasMany(AnexoProjetoArquivo::class, 'anexo_id', 'id');
    }

}
