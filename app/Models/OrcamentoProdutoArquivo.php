<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrcamentoProdutoArquivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'nm_arquivo',
        'ds_caminho',
    ];
}
