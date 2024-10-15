<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nm_empresa',
        'tp_empresa',
        'nr_cnpj',
        'nr_tel',
        'nr_cel',
        'ds_email',
        'ds_senha',
        'nr_cep',
        'ds_endereco',
        'nr_endereco',
        'ds_complemento',
        'ds_bairro',
        'nm_cidade',
        'ds_uf',
        'ds_empresa',
        'st_empresa',
        'imagem',
        'dt_validade',
    ];
}
