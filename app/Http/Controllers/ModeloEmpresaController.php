<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModeloEtapa AS Modelo;
use App\Models\ModeloEtapaDescricao AS Etapa;

class ModeloEmpresaController extends Controller
{
    public function index(){
        $empresa = session()->get('empresa');
        $modelos = Modelo::where('empresa_id', $empresa->id)->get();

        return view('acesso_empresa/modelos/index', compact('modelos'));
    }

    public function adicionar(){
        return view('acesso_empresa/modelos/adicionar');
    }

    public function insert(Request $request){
        $empresa = session()->get('empresa');
        $dados = [
            'empresa_id' => $empresa->id,
            'nm_modelo' => $request->get('nm_modelo'),
        ];
        $modelo = Modelo::create($dados);

        //vamos adicionar as etapas
        $etapas = json_decode($request->get('etapas'));

        foreach($etapas as $etapa){
            $dados = [
                'modelo_id' => $modelo->id,
                'nm_etapa' => $etapa->value,
            ];

            Etapa::create($dados);
        }

        return redirect()->route('empresa.modelo_etapa')->with('mensagem','Modelo Cadastrado!');
    }

    public function editar($id){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $id,
            'empresa_id' => $empresa->id,
        ];
        $modelo = Modelo::where($dados)->first();
        return view('acesso_empresa/modelos/editar', compact('modelo'));
    }

    public function update(Request $request){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $request->get('modelo_id'),
            'empresa_id' => $empresa->id,
        ];

        $modelo = Modelo::where($dados)->first();
        $modelo->nm_modelo = $request->get('nm_modelo');
        $modelo->save();

        Etapa::where('modelo_id', $modelo->id)->delete();

        //vamos adicionar as etapas
        $etapas = json_decode($request->get('etapas'));

        foreach($etapas as $etapa){
            $dados = [
                'modelo_id' => $modelo->id,
                'nm_etapa' => $etapa->value,
            ];

            Etapa::create($dados);
        }

        return redirect()->route('empresa.modelo_etapa')->with('mensagem','Modelo Editado!');
    }

    public function excluir($id){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $id,
            'empresa_id' => $empresa->id,
        ];
        $modelo = Modelo::where($dados)->first();
        return view('acesso_empresa/modelos/excluir', compact('modelo'));
    }

    public function delete(Request $request){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $request->get('modelo_id'),
            'empresa_id' => $empresa->id
        ];

        $modelo = Modelo::where($dados)->first();
        Etapa::where('modelo_id', $modelo->id)->delete();
        $modelo->delete();

        return redirect()->route('empresa.modelo_etapa')->with('mensagem','Modelo Excluído!');
    }

    public function visualizar($id){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $id,
            'empresa_id' => $empresa->id,
        ];
        $modelo = Modelo::where($dados)->first();
        return view('acesso_empresa/modelos/visualizar', compact('modelo'));
    }
}
