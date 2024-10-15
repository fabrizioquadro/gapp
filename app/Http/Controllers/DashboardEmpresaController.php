<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class DashboardEmpresaController extends Controller
{
    public function index(){
        return view('acesso_empresa/dashboard/index');
    }

    public function perfil(){
        $login = session()->get('login_sessao');
        if($login['tipo_login'] == "empresa"){
            $empresa = session()->get('empresa');

            return view('acesso_empresa/dashboard/perfil', compact('empresa'));
        }
    }

    public function perfil_set_foto(Request $request){
        $login = session()->get('login_sessao');

        if($login['tipo_login'] == "empresa"){
            if($request->hasFile('imagem') && $request->file('imagem')->isValid()){
                $empresa = session()->get('empresa');

                $imagem = $request->imagem;
                $extensao = $imagem->extension();

                $nmImagem = $empresa->id.".".$extensao;
                $request->imagem->move(public_path('empresas/imagem'), $nmImagem);

                $empresa->imagem = $nmImagem;
                $empresa->save();

                return redirect()->route('empresa.perfil')->with('mensagem_sucesso', 'Imagem Atualizada!');
            }
        }
    }

    public function perfil_update(Request $request){
        $login = session()->get('login_sessao');

        if($login['tipo_login'] == "empresa"){
            $empresa = session()->get('empresa');
            $dados = $request->except('_token');

            Empresa::where('id', $empresa->id)->update($dados);
            $empresa = Empresa::where('id', $empresa->id)->first();
            session()->put('empresa', $empresa);
            return redirect()->route('empresa.perfil')->with('mensagem_sucesso', 'Perfil Atualizado!');
        }
    }

    public function alterar_senha(){
        $login = session()->get('login_sessao');
        if($login['tipo_login'] == "empresa"){
            return view('acesso_empresa/dashboard/alterar_senha');
        }
    }

    public function alterar_senha_update(Request $request){
        $login = session()->get('login_sessao');
        if($login['tipo_login'] == "empresa"){
            $empresa = session()->get('empresa');

            $empresa->ds_senha = md5($request->get('nova_senha'));
            $empresa->save();
            return redirect()->route('empresa.perfil')->with('mensagem_sucesso', 'Senha Atualizada!');
        }
    }

    public function perfil_usuario(){
        $usuario = session()->get('usuario');
        return view('acesso_empresa/dashboard/perfil_usuario', compact('usuario'));
    }

    public function perfil_usuario_set_foto(Request $request){
        if($request->hasFile('imagem') && $request->file('imagem')->isValid()){
            $usuario = session()->get('usuario');

            $imagem = $request->imagem;
            $extensao = $imagem->extension();

            $nmImagem = $usuario->id.".".$extensao;
            $request->imagem->move(public_path('empresas/usuarios/imagem'), $nmImagem);

            $usuario->imagem = $nmImagem;
            $usuario->save();

            return redirect()->route('empresa.usuario.perfil')->with('mensagem_sucesso', 'Imagem Atualizada!');
        }
    }

    public function perfil_usuario_update(Request $request){
        $usuario = session()->get('usuario');
        $usuario->nm_user = $request->get('nm_user');
        $usuario->ds_email = $request->get('ds_email');
        $usuario->ds_genero = $request->get('ds_genero');

        $usuario->save();

        return redirect()->route('empresa.usuario.perfil')->with('mensagem_sucesso','Perfil Atuaizado');
    }

    public function alterar_senha_usuario(){
        return view('acesso_empresa/dashboard/alterar_senha_usuario');
    }

    public function usuario_alterar_senha_update(Request $request){
        $usuario = session()->get('usuario');
        $usuario->ds_senha = md5($request->get('nova_senha'));

        $usuario->save();
        return redirect()->route('empresa.usuario.perfil')->with('mensagem_sucesso', 'Senha Alterada!');
    }

}
