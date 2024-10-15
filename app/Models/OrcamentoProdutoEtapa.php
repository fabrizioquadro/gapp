<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrcamentoProdutoEtapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'nm_etapa',
        'st_etapa',
    ];
}
