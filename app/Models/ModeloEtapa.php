<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloEtapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'nm_modelo',
    ];

    public function etapas(){
        return $this->hasMany(ModeloEtapaDescricao::class, 'modelo_id');
    }
}
