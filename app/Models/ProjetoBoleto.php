<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetoBoleto extends Model
{
    use HasFactory;

    protected $fillable = [
        'projeto_id',
        'cliente_id',
        'nr_boleto',
        'dt_boleto',
        'vl_boleto',
        'st_boleto',
        'link_boleto',
        'id_pagamento',
        'arquivo_comprovante',
    ];
}
