<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensagem;

class MensagemEmpresaController extends Controller
{
    public function index(){
        $empresa = session()->get('empresa');
        $mensagens = Mensagem::where('empresa_id', $empresa->id)->orderBy('dt_hr_mensagem')->get();

        if($empresa->imagem){
            $avatar = "/public/empresas/imagem/$empresa->imagem";
        }
        else{
            $avatar = '/public/template/img/illustrations/trophy.png';
        }

        //vamos setar todas como lidas
        $dados_where = [
            'empresa_id' =>$empresa->id,
        ];

        $dados_update = [
            'view_Empresa' => 'Sim',
        ];

        Mensagem::where($dados_where)->update($dados_update);

        return view('acesso_empresa/mensagens/index', compact('mensagens','empresa','avatar'));
    }

    public function insert(Request $request){
        $empresa = session()->get('empresa');

        $dados = [
            'empresa_id' => $empresa->id,
            'dt_hr_mensagem' => date('Y-m-d H:i:s'),
            'ds_mensagem' => $request->get('dsMensagem'),
            'ds_emissor' => 'Empresa',
            'view_adm' => 'Não',
            'view_Empresa' => 'Sim',
        ];

        Mensagem::create($dados);

        return redirect()->route('empresa.mensagens');
    }
}
