<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    public function index(){
        $users = User::all();

        return view('usuarios/index', compact('users'));
    }

    public function adicionar(){
        return view('usuarios/adicionar');
    }

    public function insert(Request $request){
        $dados = $request->all();
        $user = User::create($dados);

        if($request->hasFile('imagem') && $request->file('imagem')->isValid()){
            $imagem = $request->imagem;
            $extensao = $imagem->extension();

            $nmImagem = $user->id.".".$extensao;

            $request->imagem->move(public_path('/users/imagem'), $nmImagem);

            $user->imagem = $nmImagem;

            $user->save();
        }

        return redirect()->route('admin.usuarios')->with('mensagem', 'Usuário Cadastrado!');
    }

    public function editar($id){
        $user = User::where('id', $id)->first();

        return view('usuarios/editar', compact('user'));
    }

    public function update(Request $request){
        $id = $request->get('user_id');
        $dados = $request->except('_token','user_id');

        User::where('id', $id)->update($dados);
        $user = User::where('id', $id)->first();

        if($request->hasFile('imagem') && $request->file('imagem')->isValid()){
            $imagem = $request->imagem;
            $extensao = $imagem->extension();

            $nmImagem = $user->id.".".$extensao;

            $request->imagem->move(public_path('/users/imagem'), $nmImagem);

            $user->imagem = $nmImagem;

            $user->save();
        }

        return redirect()->route('admin.usuarios')->with('mensagem', 'Usuário Editado!');
    }

    public function alterar_senha($id){
        $user = User::where('id', $id)->first();

        return view('usuarios/alterar_senha', compact('user'));
    }

    public function alterar_senha_update(Request $request){
        $id = $request->get('user_id');
        $dados = [
            'password' => bcrypt($request->get('nova_senha')),
        ];

        User::where('id', $id)->update($dados);
        return redirect()->route('admin.usuarios')->with('mensagem', 'Senha Alterada!!');
    }

    public function excluir($id){
        $user = User::where('id', $id)->first();

        return view('usuarios/excluir', compact('user'));
    }

    public function delete(Request $request){
        $id = $request->get('user_id');

        User::where('id', $id)->delete();
        return redirect()->route('admin.usuarios')->with('mensagem', 'Usuário Excluído!!');
    }
}
