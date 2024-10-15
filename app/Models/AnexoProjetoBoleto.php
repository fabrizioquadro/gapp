<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnexoProjetoBoleto extends Model
{
    use HasFactory;

    protected $fillable = [
        'anexo_id',
        'projeto_id',
        'cliente_id',
        'nr_boleto',
        'dt_boleto',
        'vl_boleto',
        'st_boleto',
        'arquivo_comprovante',
    ];
}
