<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard/index');
    }

    public function perfil(){
        $user = auth()->user();

        return view('dashboard/perfil', compact('user'));
    }

    public function perfil_set_foto(Request $request){
        if($request->hasFile('imagem') && $request->file('imagem')->isValid()){
            $user = auth()->user();
            $imagem = $request->imagem;
            $extensao = $imagem->extension();

            $nmImagem = $user->id.".".$extensao;
            $request->imagem->move(public_path('users/imagem'), $nmImagem);

            $user->imagem = $nmImagem;
            $user->save();

            return redirect()->route('admin.perfil')->with('mensagem_sucesso', 'Imagem Atualizada!');
        }
    }

    public function perfil_excluir_foto(){
        $user = auth()->user();
        $user->imagem = null;

        $user->save();
        return redirect()->route('admin.perfil')->with('mensagem_sucesso', 'Imagem Atualizada!');
    }

    public function perfil_update(Request $request){
        $user = auth()->user();
        $dados = $request->except('_token');

        User::where('id', $user->id)->update($dados);
        return redirect()->route('admin.perfil')->with('mensagem_sucesso', 'Perfil Atualizado!');
    }

    public function alterar_senha(){
        return view('dashboard/alterar_senha');
    }

    public function alterar_senha_update(Request $request){
        $user = auth()->user();

        $user->password = bcrypt($request->get('nova_senha'));
        $user->save();
        return redirect()->route('admin.perfil')->with('mensagem_sucesso', 'Senha Atualizado!');
    }
}
