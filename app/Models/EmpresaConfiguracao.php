<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaConfiguracao extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'asaas_client',
        'asaas_method',
        'tipo_pix',
        'chave_pix',
        'modelo_contrato',
        'modelo_contrato_anexo',
    ];
}
