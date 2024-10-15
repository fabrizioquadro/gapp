<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plano;
use LifenPag\Asaas\V3\Entities\Payment as PaymentEntity;
use LifenPag\Asaas\V3\Domains\Customer as CustomerDomain;
use LifenPag\Asaas\V3\Client;

class PlanoEmpresaController extends Controller
{
    public function index(){
        $planos = Plano::all()->sortBy('vl_plano');
        $empresa = session()->get('empresa');

        return view('acesso_empresa/planos/index', compact('planos','empresa'));
    }

    public function adquirir($id){
        $plano = Plano::where('id', $id)->first();

        return view('acesso_empresa/planos/adquirir', compact('plano'));
    }

    public function comprar(Request $request){
        $plano = Plano::where('id', $request->get('plano_id'))->first();
        $empresa = session()->get('empresa');

        $hoje = date('Y-m-d');
        if(strtotime($hoje > strtotime($empresa->dt_validade))){
            $data = $hoje;
        }
        else{
            $data = $empresa->dt_validade;
        }

        $empresa->dt_validade = date('Y-m-d', strtotime("+$plano->dias_validade days", strtotime($data)));

        return redirect()->route('empresa.planos')->with('mensagem','Plano Adquirido!');
    }
}
