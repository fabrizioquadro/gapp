<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Mensagem;

class EmpresaController extends Controller
{
    public function index(){
        $empresas = Empresa::all();

        return view('empresas/index', compact('empresas'));
    }

    public function adicionar(){
        return view('empresas/adicionar');
    }

    public function insert(Request $request){
        $dados = $request->except('_token','password');
        $dados['ds_senha'] = md5($request->get('password'));
        $dados['dt_validade'] = date('Y-m-d', strtotime("+30 days", strtotime(date('Y-m-d'))));

        $empresa = Empresa::create($dados);

        if($request->hasFile('imagem') && $request->file('imagem')->isValid()){
            $imagem = $request->imagem;
            $extensao = $imagem->extension();

            $nmImagem = $empresa->id.".".$extensao;

            $request->imagem->move(public_path('/empresas/imagem'), $nmImagem);

            $empresa->imagem = $nmImagem;

            $empresa->save();
        }
        return redirect()->route('admin.empresas')->with('mensagem','Empresa Cadastrada!');
    }

    public function editar($id){
        $empresa = Empresa::where('id', $id)->first();

        return view('empresas/editar', compact('empresa'));
    }

    public function update(Request $request){
        $id = $request->get('empresa_id');
        $dados = $request->except('_token','empresa_id');

        Empresa::where('id', $id)->update($dados);
        $empresa = Empresa::where('id', $id)->first();

        if($request->hasFile('imagem') && $request->file('imagem')->isValid()){
            $imagem = $request->imagem;
            $extensao = $imagem->extension();

            $nmImagem = $empresa->id.".".$extensao;

            $request->imagem->move(public_path('/empresas/imagem'), $nmImagem);

            $empresa->imagem = $nmImagem;

            $empresa->save();
        }
        return redirect()->route('admin.empresas')->with('mensagem','Empresa Editada!');
    }

    public function alterar_senha($id){
        $empresa = Empresa::where('id', $id)->first();

        return view('empresas/alterar_senha', compact('empresa'));
    }

    public function alterar_senha_update(Request $request){
        $id = $request->get('empresa_id');

        $dados = [
            'ds_senha' => md5($request->get('nova_senha')),
        ];

        Empresa::where('id', $id)->update($dados);

        return redirect()->route('admin.empresas')->with('mensagem','Senha Alterada!');
    }

    public function excluir($id){
        $empresa = Empresa::where('id', $id)->first();

        return view('empresas/excluir', compact('empresa'));
    }

    public function delete(Request $request){
        $id = $request->get('empresa_id');

        Empresa::where('id', $id)->delete();

        return redirect()->route('admin.empresas')->with('mensagem','Empresa Excluída!!');
    }

    public function visualizar($id){
        $empresa = Empresa::where('id', $id)->first();

        return view('empresas/visualizar', compact('empresa'));
    }

    public function mensagens($id){
        $empresa = Empresa::where('id', $id)->first();
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
            'view_adm' => 'Sim',
        ];

        Mensagem::where($dados_where)->update($dados_update);

        return view('empresas/mensagens', compact('empresa', 'mensagens','avatar'));
    }

    public function mensagem_insert(Request $request){
        $dados = [
            'empresa_id' => $request->get('empresa_id'),
            'dt_hr_mensagem' => date('Y-m-d H:i:s'),
            'ds_mensagem' => $request->get('dsMensagem'),
            'ds_emissor' => 'Adm',
            'view_adm' => 'Sim',
            'view_Empresa' => 'Não',
        ];

        Mensagem::create($dados);

        return redirect()->route('admin.empresas.mensagens', $request->get('empresa_id'));
    }

}
