<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    use HasFactory;

    protected $fillable = [
        'nm_plano',
        'ds_plano',
        'dias_validade',
        'vl_plano',
    ];
}
