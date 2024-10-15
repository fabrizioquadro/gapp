<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'projeto_id',
        'ds_obs',
        'tp_obs',
        'dt_hr_obs',
    ];

    public function arquivos(){
        return $this->hasMany(ObservacaoArquivo::class);
    }
}
