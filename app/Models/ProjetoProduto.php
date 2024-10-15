<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetoProduto extends Model
{
    use HasFactory;

    protected $fillable = [
        'projeto_id',
        'produto_id',
        'dt_entrega',
        'situacao',
    ];

    public function produto(){
        return $this->belongsTo(OrcamentoProduto::class, 'produto_id', 'id');
    }
}
