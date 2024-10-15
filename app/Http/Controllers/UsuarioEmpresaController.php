<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioEmpresa AS Usuario;

class UsuarioEmpresaController extends Controller
{
    public function index(){
        $login = session()->get('login_sessao');
        if($login['tipo_login'] == "empresa"){
            $empresa = session()->get('empresa');
            $usuarios = Usuario::where('empresa_id', $empresa->id)->get();

            return view('acesso_empresa/usuarios/index', compact('usuarios'));
        }

    }

    public function adicionar(){
        $login = session()->get('login_sessao');
        if($login['tipo_login'] == "empresa"){
            return view('acesso_empresa/usuarios/adicionar');
        }
    }

    public function insert(Request $request){
        $login = session()->get('login_sessao');
        if($login['tipo_login'] == "empresa"){
            $dados = $request->except('_token');
            $empresa = session()->get('empresa');
            $dados['empresa_id'] = $empresa->id;
            $dados['ds_senha'] = md5($dados['ds_senha']);

            $user = Usuario::create($dados);

            if($request->hasFile('imagem') && $request->file('imagem')->isValid()){

                $imagem = $request->imagem;
                $extensao = $imagem->extension();

                $nmImagem = $user->id.".".$extensao;
                $request->imagem->move(public_path('empresas/usuarios/imagem'), $nmImagem);

                $user->imagem = $nmImagem;
                $user->save();

            }
            return redirect()->route('empresa.usuarios')->with('mensagem', 'Usuário Cadastrado!');
        }
    }

    public function editar($id){
        $login = session()->get('login_sessao');
        if($login['tipo_login'] == 'empresa'){
            $empresa = session()->get('empresa');
            $dados = [
                'id' => $id,
                'empresa_id' => $empresa->id,
            ];
            $user = Usuario::where($dados)->first();
            return view('acesso_empresa/usuarios/editar', compact('user'));
        }
    }

    public function update(Request $request){
        $login = session()->get('login_sessao');
        if($login['tipo_login'] == 'empresa'){
            $empresa = session()->get('empresa');
            $dados_where = [
                'id' => $request->get('user_id'),
                'empresa_id' => $empresa->id,
            ];

            $dados_update = $request->except('user_id','_token');
            Usuario::where($dados_where)->update($dados_update);
            $user = Usuario::where($dados_where)->first();

            if($request->hasFile('imagem') && $request->file('imagem')->isValid()){

                $imagem = $request->imagem;
                $extensao = $imagem->extension();

                $nmImagem = $user->id.".".$extensao;
                $request->imagem->move(public_path('empresas/usuarios/imagem'), $nmImagem);

                $user->imagem = $nmImagem;
                $user->save();
            }

            return redirect()->route('empresa.usuarios')->with('mensagem', 'Usuário Editado!');

        }
    }

    public function alterar_senha($id){
        $login = session()->get('login_sessao');
        if($login['tipo_login'] == 'empresa'){
            $empresa = session()->get('empresa');
            $dados = [
                'id' => $id,
                'empresa_id' => $empresa->id,
            ];
            $user = Usuario::where($dados)->first();
            return view('acesso_empresa/usuarios/alterar_senha', compact('user'));
        }
    }

    public function alterar_senha_update(Request $request){
        $login = session()->get('login_sessao');
        if($login['tipo_login'] == 'empresa'){
            $empresa = session()->get('empresa');
            $dados = [
                'id' => $request->get('user_id'),
                'empresa_id' => $empresa->id,
            ];
            $dados_update = [
                'ds_senha' => md5($request->get('nova_senha')),
            ];

            Usuario::where($dados)->update($dados_update);
            return redirect()->route('empresa.usuarios')->with('mensagem', 'Senha Alterada!');
        }
    }

    public function excluir($id){
        $login = session()->get('login_sessao');
        if($login['tipo_login'] == 'empresa'){
            $empresa = session()->get('empresa');
            $dados = [
                'id' => $id,
                'empresa_id' => $empresa->id,
            ];
            $user = Usuario::where($dados)->first();
            return view('acesso_empresa/usuarios/excluir', compact('user'));
        }
    }

    public function delete(Request $request){
        $login = session()->get('login_sessao');
        if($login['tipo_login'] == 'empresa'){
            $empresa = session()->get('empresa');
            $dados = [
                'id' => $request->get('user_id'),
                'empresa_id' => $empresa->id,
            ];

            Usuario::where($dados)->delete();
            return redirect()->route('empresa.usuarios')->with('mensagem', 'Usuário Excluído!');
        }
    }
}
