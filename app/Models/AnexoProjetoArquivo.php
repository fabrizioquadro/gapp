<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnexoProjetoArquivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'anexo_id',
        'nm_arquivo',
        'ds_caminho',
    ];
}
