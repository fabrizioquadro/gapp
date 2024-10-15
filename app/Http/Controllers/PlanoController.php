<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plano;

class PlanoController extends Controller
{
    public function index(){
        $planos = Plano::all();

        return view('planos/index', compact('planos'));
    }

    public function adicionar(){
        return view('planos/adicionar');
    }

    public function insert(Request $request){
        $dados = $request->all();
        $dados['vl_plano'] = valorFormDb($dados['vl_plano']);

        Plano::create($dados);

        return redirect()->route('admin.planos')->with('mensagem','Plano Cadastrado');
    }

    public function editar($id){
        $plano = Plano::where('id', $id)->first();
        return view('planos/editar', compact('plano'));
    }

    public function update(Request $request){
        $plano_id = $request->get('plano_id');

        $dados = $request->except('_token','plano_id');
        $dados['vl_plano'] = valorFormDb($dados['vl_plano']);

        Plano::where('id', $plano_id)->update($dados);

        return redirect()->route('admin.planos')->with('mensagem','Plano Editado!');
    }

    public function excluir($id){
        $plano = Plano::where('id', $id)->first();
        return view('planos/excluir', compact('plano'));
    }

    public function delete(Request $request){
        $plano_id = $request->get('plano_id');

        Plano::where('id', $plano_id)->delete();
        return redirect()->route('admin.planos')->with('mensagem','Plano Excluída!');
    }
}
