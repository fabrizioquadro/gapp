<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'dt_hr_mensagem',
        'ds_mensagem',
        'ds_emissor',
        'view_adm',
        'view_Empresa',
    ];
}
