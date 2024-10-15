<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracaoPadrao extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'modelo_contrato',
        'modelo_contrato_anexo',
    ];
}
