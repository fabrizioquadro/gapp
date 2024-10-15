<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteEmpresaController extends Controller
{
    public function index(){
        $empresa = session()->get('empresa');
        $clientes = Cliente::where('empresa_id', $empresa->id)->get();
        return view('acesso_empresa/clientes/index', compact('clientes'));
    }

    public function adicionar(){
        return view('acesso_empresa/clientes/adicionar');
    }

    public function insert(Request $request){
        $empresa = session()->get('empresa');
        $dados = $request->except('_token','enviar_senha_cliente');
        $dados['empresa_id'] = $empresa->id;

        $cliente = Cliente::create($dados);

        if($request->get('enviar_senha_cliente') == "sim"){
            //se entrar aqui vai ser gerado a senha e enviar o email com os dados de acesso
            $nova_senha = createPassword(8, true, true, true, false);
            $cliente->ds_senha = md5($nova_senha);
            $cliente->save();

            $mensagem = "
            <h3>Gapp Sistema Inteligente</h3>
            <p>
                Você foi adicionado ao Sistema Inteligente da empresa $empresa->nm_empresa <br>
                Link de Acesso: ".link_acesso_cliente()."<br>
                Usuário: $cliente->ds_email <br>
                Senha: $nova_senha
            </p>
            ";

            enviarMail($cliente->ds_email, "Bem Vindo ao Gapp Sistema Inteligente - $empresa->nm_empresa", $mensagem);
        }

        return redirect()->route('empresa.clientes')->with('mensagem','Cliente Cadastrado');
    }

    public function editar($id){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $id,
            'empresa_id' => $empresa->id,
        ];

        $cliente = Cliente::where($dados)->first();
        return view('acesso_empresa/clientes/editar', compact('cliente'));
    }

    public function update(Request $request){
        $empresa = session()->get('empresa');
        $cliente = Cliente::where('id', $request->get('cliente_id'))->first();

        if($empresa->id == $cliente->empresa_id){
            $dados = $request->except('_token','cliente_id');
            Cliente::where('id', $cliente->id)->update($dados);
            return redirect()->route('empresa.clientes')->with('mensagem','Cliente Editado!');
        }
        else{
            return redirect()->route('empresa.clientes')->with('mensagem','Este cliente não é da sua empresa');
        }
    }

    public function alterar_senha($id){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $id,
            'empresa_id' => $empresa->id,
        ];

        $cliente = Cliente::where($dados)->first();
        return view('acesso_empresa/clientes/alterar_senha', compact('cliente'));
    }

    public function alterar_senha_update(Request $request){
        $empresa = session()->get('empresa');
        $cliente = Cliente::where('id', $request->get('cliente_id'))->first();

        if($empresa->id == $cliente->empresa_id){
            $senha = md5($request->get('nova_senha'));
            $dados = [
                'ds_senha' => $senha,
            ];
            Cliente::where('id', $cliente->id)->update($dados);
            return redirect()->route('empresa.clientes')->with('mensagem','Senha Alterada!');
        }
        else{
            return redirect()->route('empresa.clientes')->with('mensagem','Este cliente não é da sua empresa');
        }
    }

    public function enviar_email_acesso($id){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $id,
            'empresa_id' => $empresa->id,
        ];

        $cliente = Cliente::where($dados)->first();
        return view('acesso_empresa/clientes/enviar_email_acesso', compact('cliente'));
    }

    public function enviar_email_acesso_send(Request $request){
        $empresa = session()->get('empresa');
        $cliente = Cliente::where('id', $request->get('cliente_id'))->first();

        if($empresa->id == $cliente->empresa_id){
            $nova_senha = createPassword(8, true, true, true, false);
            $cliente->ds_senha = md5($nova_senha);
            $cliente->save();

            $mensagem = "
            <h3>Gapp Sistema Inteligente</h3>
            <p>
                Você foi adicionado ao Sistema Inteligente da empresa $empresa->nm_empresa <br>
                Link de Acesso: ".link_acesso_cliente()."<br>
                Usuário: $cliente->ds_email <br>
                Senha: $nova_senha
            </p>
            ";

            enviarMail($cliente->ds_email, "Bem Vindo ao Gapp Sistema Inteligente - $empresa->nm_empresa", $mensagem);
            return redirect()->route('empresa.clientes')->with('mensagem','Email Enviado!');
        }
        else{
            return redirect()->route('empresa.clientes')->with('mensagem','Este cliente não é da sua empresa');
        }
    }

    public function visualizar($id){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $id,
            'empresa_id' => $empresa->id,
        ];

        $cliente = Cliente::where($dados)->first();
        return view('acesso_empresa/clientes/visualizar', compact('cliente'));
    }

    public function excluir($id){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $id,
            'empresa_id' => $empresa->id,
        ];

        $cliente = Cliente::where($dados)->first();
        return view('acesso_empresa/clientes/excluir', compact('cliente'));
    }

    public function delete(Request $request){
        $empresa = session()->get('empresa');
        $cliente = Cliente::where('id', $request->get('cliente_id'))->first();

        if($empresa->id == $cliente->empresa_id){
            Cliente::where('id', $cliente->id)->delete();
            return redirect()->route('empresa.clientes')->with('mensagem','Cliente Excluído!');
        }
        else{
            return redirect()->route('empresa.clientes')->with('mensagem','Este cliente não é da sua empresa');
        }
    }
}
