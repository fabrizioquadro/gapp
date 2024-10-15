<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrcamentoArquivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'orcamento_id',
        'nm_arquivo',
        'ds_caminho',
    ];
}
