<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioEmpresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'nm_user',
        'ds_email',
        'ds_senha',
        'ds_genero',
        'imagem',
    ];
}
