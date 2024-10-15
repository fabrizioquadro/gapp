<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class DashboardClienteController extends Controller
{
    public function index(){
        return view('acesso_cliente/dashboard/index');
    }

    public function perfil(){
        $cliente = session()->get('cliente');

        return view('acesso_cliente/dashboard/perfil', compact('cliente'));
    }

    public function perfil_update(Request $request){
        $cliente = session()->get('cliente');
        $cliente->nm_cliente = $request->get('nm_cliente');
        $cliente->tp_cliente = $request->get('tp_cliente');
        $cliente->nr_cpf = $request->get('nr_cpf');
        $cliente->ds_email = $request->get('ds_email');
        $cliente->nr_tel = $request->get('nr_tel');
        $cliente->nr_cel = $request->get('nr_cel');
        $cliente->ds_endereco = $request->get('ds_endereco');
        $cliente->nr_endereco = $request->get('nr_endereco');
        $cliente->ds_complemento = $request->get('ds_complemento');
        $cliente->ds_bairro = $request->get('ds_bairro');
        $cliente->nm_cidade = $request->get('nm_cidade');
        $cliente->ds_uf = $request->get('ds_uf');
        $cliente->nr_cep = $request->get('nr_cep');

        $cliente->save();

        return redirect()->route('cliente.perfil')->with('mensagem', 'Dados Editados!');
    }

    public function alterar_senha(){
        return view('acesso_cliente/dashboard/alterar_senha');
    }

    public function alterar_senha_update(Request $request){
        $cliente = session()->get('cliente');
        $cliente->ds_senha = md5($request->get('nova_senha'));

        $cliente->save();
        return redirect()->route('cliente.perfil')->with('mensagem', 'Senha Alterada!');
    }
}
