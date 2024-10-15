<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;

    protected $fillable = [
        'orcamento_id',
        'empresa_id',
        'cliente_id',
        'nm_projeto',
        'ds_projeto',
        'dt_contratacao',
        'vl_projeto',
        'ds_forma_pagamento',
        'obs_forma_pagamento',
        'ip_contratante',
        'caminho_contrato_pdf',
        'st_projeto',
    ];

    public function getProximaEntrega(){
        $dados = [
            'projeto_id' => $this->id,
            'situacao' => 'Aberto',
        ];
        $produto = ProjetoProduto::where($dados)->orderBy('dt_entrega')->first();
        return $produto ? $produto->dt_entrega : null;
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function proj_produtos(){
        return ProjetoProduto::where('projeto_id', $this->id)->get();
    }

    public function orcamento(){
        return $this->belongsTo(Orcamento::class);
    }

    public function boletos(){
        return $this->hasMany(ProjetoBoleto::class);
    }

    public function anexos(){
        return $this->hasMany(AnexoProjeto::class);
    }

    public function observacoes(){
        return $this->hasMany(Observacao::class);
    }

}
