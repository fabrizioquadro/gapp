<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacaoArquivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'observacao_id',
        'nm_arquivo',
        'ds_caminho',
    ];
}
