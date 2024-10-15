<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'titulo',
        'descricao',
        'validade',
        'st_orcamento',
        'desconto_avista',
        'parcelamento_cartao',
        'parcelamento_entrada',
        'vencimento_entrada',
        'parcelamento_vezes',
        'entrega_entrada',
        'entrega_vencimento',
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function produtos(){
        return $this->hasMany(OrcamentoProduto::class);
    }

    public function arquivos(){
        return $this->hasMany(OrcamentoArquivo::class);
    }

    public function get_valor_orcamento(){
        return OrcamentoProduto::where('orcamento_id', $this->id)->sum('vl_produto');
    }
}
