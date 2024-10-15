<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpresaConfiguracao AS Config;
use App\Models\ConfiguracaoPadrao AS Padrao;

class ConfiguracaoEmpresaController extends Controller
{
    public function index(){
        $empresa = session()->get('empresa');
        $config = Config::where('empresa_id', $empresa->id)->first();
        $padrao = Padrao::where('id', '1')->first();

        return view('acesso_empresa/configuracao/index', compact('config','padrao'));
    }

    public function set_asaas(Request $request){
        $empresa = session()->get('empresa');
        $config = Config::where('empresa_id', $empresa->id)->first();
        $dados = [
            'asaas_method' => $request->get('asaas_method'),
            'asaas_client' => $request->get('asaas_client'),
        ];

        if($config){
            Config::where('empresa_id', $empresa->id)->update($dados);
        }
        else{
            $dados['empresa_id'] = $empresa->id;
            Config::create($dados);
        }

        return redirect()->route('empresa.configuracao')->with('mensagem','Dados Integração Asaas Salvos!');
    }

    public function set_pix(Request $request){
        $empresa = session()->get('empresa');
        $config = Config::where('empresa_id', $empresa->id)->first();
        $dados = [
            'tipo_pix' => $request->get('tipo_pix'),
            'chave_pix' => $request->get('chave_pix'),
        ];

        if($config){
            Config::where('empresa_id', $empresa->id)->update($dados);
        }
        else{
            $dados['empresa_id'] = $empresa->id;
            Config::create($dados);
        }

        return redirect()->route('empresa.configuracao')->with('mensagem','Dados Pix Salvos!');
    }

    public function set_modelo_contrato(Request $request){
        $empresa = session()->get('empresa');
        $config = Config::where('empresa_id', $empresa->id)->first();
        $dados = [
            'modelo_contrato' => $request->get('modelo_contrato'),
        ];

        if($config){
            Config::where('empresa_id', $empresa->id)->update($dados);
        }
        else{
            $dados['empresa_id'] = $empresa->id;
            Config::create($dados);
        }

        return redirect()->route('empresa.configuracao')->with('mensagem','Modelo Contrato Salvos!');
    }

    public function set_modelo_contrato_anexo(Request $request){
        $empresa = session()->get('empresa');
        $config = Config::where('empresa_id', $empresa->id)->first();
        $dados = [
            'modelo_contrato_anexo' => $request->get('modelo_contrato_anexo'),
        ];

        if($config){
            Config::where('empresa_id', $empresa->id)->update($dados);
        }
        else{
            $dados['empresa_id'] = $empresa->id;
            Config::create($dados);
        }

        return redirect()->route('empresa.configuracao')->with('mensagem','Modelo Contrato Anexo Salvos!');
    }
}
