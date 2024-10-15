<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrcamentoProduto extends Model
{
    use HasFactory;

    protected $fillable = [
        'orcamento_id',
        'nm_produto',
        'ds_produto',
        'vl_produto',
        'dias_entrega',
        'st_produto',
    ];

    public function arquivos(){
        return $this->hasMany(OrcamentoProdutoArquivo::class, 'produto_id', 'id');
    }

    public function etapas(){
        return $this->hasMany(OrcamentoProdutoEtapa::class, 'produto_id', 'id');
    }
}
