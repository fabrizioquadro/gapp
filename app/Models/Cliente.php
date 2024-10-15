<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LifenPag\Asaas\V3\Entities\Customer as CustomerEntity;
use LifenPag\Asaas\V3\Client;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'nm_cliente',
        'tp_cliente',
        'nr_cpf',
        'ds_email',
        'ds_senha',
        'nr_tel',
        'nr_cel',
        'ds_endereco',
        'nr_endereco',
        'ds_complemento',
        'ds_bairro',
        'nm_cidade',
        'ds_uf',
        'nr_cep',
        'custon_id_asaas',
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function verifica_id_customer_asaas(){
        if(!$this->custon_id_asaas){
            $cpf = str_replace('.','',$this->nr_cpf);
            $cpf = str_replace('-','',$cpf);

            $config = EmpresaConfiguracao::where('empresa_id', $this->empresa_id)->first();

            $asaas_client = $config->asaas_client;
            $asaas_method = $config->asaas_method;

            Client::connect($asaas_client, $asaas_method);

            $customer = new CustomerEntity();
            $customer->name = $this->nm_cliente;
            $customer->email = $this->ds_email;
            $customer->cpfCnpj = $cpf;

            $customerCreated = $customer->create();

            $this->custon_id_asaas = $customerCreated->id;
            $this->save();
        }
    }
}
