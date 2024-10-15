<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projeto;
use App\Models\ProjetoBoleto;
use App\Models\AnexoProjeto;
use App\Models\AnexoProjetoArquivo;
use App\Models\AnexoProjetoBoleto;
use App\Models\Orcamento;
use App\Models\OrcamentoProduto AS Produto;
use App\Models\OrcamentoProdutoEtapa AS Etapa;
use App\Models\Observacao;
use App\Models\ObservacaoArquivo;

class ProjetoEmpresaController extends Controller
{
    public function index(){
        $empresa = session()->get('empresa');
        $projetos = Projeto::where('empresa_id', $empresa->id)->get();

        return view('acesso_empresa/projetos/index', compact('projetos'));
    }

    public function acessar($id){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $id,
            'empresa_id' => $empresa->id,
        ];
        $projeto = Projeto::where($dados)->first();

        //vamos analizar a porcentagem que já foi paga desse projeto
        $vl_projeto = $projeto->vl_projeto;

        if($projeto->ds_forma_pagamento == 'Cartão de Crédito'){
            $vl_pago = $projeto->vl_projeto;
        }
        else{
            $vl_pago = 0;
            foreach($projeto->boletos as $boleto){
                if($boleto->st_boleto == "Pago"){
                    $vl_pago += $boleto->vl_boleto;
                }
            }
        }

        //vamos adicionar os valores dos anexos
        foreach($projeto->anexos as $anexo){
            if($anexo->st_anexo == "Contratado"){
                $vl_projeto += $anexo->vl_anexo;
                if($anexo->ds_forma_pagamento == "Cartão de Crédito"){
                    $vl_pago += $anexo->vl_anexo;
                }
                else{
                    $boleto = AnexoProjetoBoleto::where('anexo_id', $anexo->id)->first();
                    if($boleto->st_boleto == 'Pago'){
                        $vl_pago += $boleto->vl_boleto;
                    }
                }
            }
        }

        $porcentagem_paga = round($vl_pago * 100 / $vl_projeto);

        //vamos verificar a conclusao das etapas
        $array_etapas = array();

        foreach($projeto->proj_produtos() as $prod){
            $array_etapas[$prod->produto->id] = $this->calc_porcentagem_etapa_concluida($prod->produto->id);
        }

        return view('acesso_empresa/projetos/acessar', compact('projeto','porcentagem_paga','array_etapas'));
    }

    public function adicionar_anexo(Request $request){
        $projeto = Projeto::where('id', $request->get('projeto_id'))->first();
        $empresa = session()->get('empresa');
        if($projeto->empresa_id == $empresa->id){
            $dados = $request->except('_token','vl_anexo');
            $dados['cliente_id'] = $projeto->cliente_id;
            $dados['vl_anexo'] = valorFormDb($request->get('vl_anexo'));
            $dados['st_anexo'] = 'Aberto';

            $anexo = AnexoProjeto::create($dados);

            if($request->hasFile('arquivos')){
                foreach($request->file('arquivos') as $arquivo){
                    if($arquivo->isValid()){
                        $nm_arquivo = $arquivo->getClientOriginalName();
                        $caminho = "/projetos/$projeto->id/anexos";
                        $arquivo->move(public_path($caminho), $nm_arquivo);

                        $dados_arq = [
                            'anexo_id' => $anexo->id,
                            'nm_arquivo' => $nm_arquivo,
                            'ds_caminho' => $caminho,
                        ];

                        AnexoProjetoArquivo::create($dados_arq);
                    }
                }
            }

            return redirect()->route('empresa.projetos.acessar', $projeto->id)->with('mensagem', 'Anexo Adicionado!');
        }
    }

    public function buscar_anexo(){
        $anexo_id = $_GET['anexo_id'];
        $anexo = AnexoProjeto::where('id', $anexo_id)->first();

        $empresa = session()->get('empresa');

        if($empresa->id == $anexo->projeto->empresa_id){
            $retorno['anexo_id'] = $anexo->id;
            $retorno['nm_anexo'] = $anexo->nm_anexo;
            $retorno['ds_anexo'] = $anexo->ds_anexo;
            $retorno['vl_anexo'] = valorDbForm($anexo->vl_anexo);
            $retorno['ds_forma_pagamento'] = $anexo->ds_forma_pagamento;

            //vamos buscar os arquivos
            $retorno['arquivos'] = 'false';
            $html = "<hr>
                    <ul>
                    <h6 class='card-title'>Arquivos</h6>
                    ";

            $html_view = "<hr>
                    <ul>
                    <h6 class='card-title'>Arquivos</h6>
                    ";

            foreach($anexo->arquivos as $arquivo){
                $retorno['arquivos'] = 'true';
                $html.= "
                <li id='li_editar_arquivo_$arquivo->id'>
                    <div class='d-flex justify-content-between mb-2'>
                        <a href='/public/$arquivo->ds_caminho/$arquivo->nm_arquivo' class='btn btn-text-secondary waves-effect waves-light' target='_blank'>$arquivo->nm_arquivo</a>
                        <button type='button' class='btn btn-xs rounded-pill btn-outline-danger waves-effect' onclick='delete_arq_anexo($arquivo->id)'>Excluir</button>
                    </div>
                </li>
                ";

                $html_view.= "
                <li>
                    <a href='/public/$arquivo->ds_caminho/$arquivo->nm_arquivo' class='btn btn-text-secondary waves-effect waves-light' target='_blank'>$arquivo->nm_arquivo</a>
                </li>
                ";
            }
            $html .= "</ul>";
            $html_view .= "</ul>";

            $retorno['html'] = $html;
            $retorno['html_view'] = $html_view;
            echo json_encode($retorno);
        }
    }

    public function update_anexo(Request $request){
        $anexo_id = $request->get('anexo_id');
        $anexo = AnexoProjeto::where('id', $anexo_id)->first();

        $empresa = session()->get('empresa');

        if($empresa->id == $anexo->projeto->empresa_id){
            $dados = $request->except('_token','vl_anexo','anexo_id','arquivos');
            $dados['vl_anexo'] = valorFormDb($request->get('vl_anexo'));

            AnexoProjeto::where('id', $anexo->id)->update($dados);

            if($request->hasFile('arquivos')){
                foreach($request->file('arquivos') as $arquivo){
                    if($arquivo->isValid()){
                        $nm_arquivo = $arquivo->getClientOriginalName();
                        $caminho = "/projetos/".$anexo->projeto->id."/anexos";
                        $arquivo->move(public_path($caminho), $nm_arquivo);

                        $dados_arq = [
                            'anexo_id' => $anexo->id,
                            'nm_arquivo' => $nm_arquivo,
                            'ds_caminho' => $caminho,
                        ];

                        AnexoProjetoArquivo::create($dados_arq);
                    }
                }
            }

            return redirect()->route('empresa.projetos.acessar', $anexo->projeto->id)->with('mensagem', 'Anexo Editado!');
        }
    }

    public function excluir_arquivo_anexo(){
        $arquivo = AnexoProjetoArquivo::where('id', $_GET['arquivo_id'])->first();
        $anexo = AnexoProjeto::where('id', $arquivo->anexo_id)->first();
        $empresa = session()->get('empresa');
        $retorno['controle'] = 'false';

        if($empresa->id == $anexo->projeto->empresa_id){
            $retorno['controle'] = 'true';
            $retorno['linha'] = "li_editar_arquivo_$arquivo->id";
            $arquivo->delete();
        }

        echo json_encode($retorno);
    }

    public function delete_anexo($id = null){
        $anexo = AnexoProjeto::where('id', $id)->first();
        $empresa = session()->get('empresa');

        if($empresa->id == $anexo->projeto->empresa_id){
            //vamos apagar os Arquivos
            AnexoProjetoArquivo::where('anexo_id', $anexo->id)->delete();
            $anexo->delete();
            return redirect()->route('empresa.projetos.acessar', $anexo->projeto->id)->with('mensagem', 'Anexo Excluído!');
        }
    }

    public function set_pagamento($id = null){
        $empresa = session()->get('empresa');
        $boleto = ProjetoBoleto::where('id', $id)->first();
        $projeto = Projeto::where('id', $boleto->projeto_id)->first();

        if($empresa->id == $projeto->empresa_id){
            $boleto->st_boleto = "Pago";
            $boleto->save();

            return redirect()->route('empresa.projetos.acessar', $projeto->id)->with('mensagem', 'Pagamento Cadastrado!');
        }
    }

    public function set_pagamento_anexo($id = null){
        $empresa = session()->get('empresa');
        $boleto = AnexoProjetoBoleto::where('id', $id)->first();
        $projeto = Projeto::where('id', $boleto->projeto_id)->first();

        if($empresa->id == $projeto->empresa_id){
            $boleto->st_boleto = "Pago";
            $boleto->save();

            return redirect()->route('empresa.projetos.acessar', $projeto->id)->with('mensagem', 'Pagamento Cadastrado!');
        }
    }

    public function cancela_pagamento($id = null){
        $empresa = session()->get('empresa');
        $boleto = ProjetoBoleto::where('id', $id)->first();
        $projeto = Projeto::where('id', $boleto->projeto_id)->first();

        if($empresa->id == $projeto->empresa_id){
            $boleto->st_boleto = "Aberto";
            $boleto->save();

            return redirect()->route('empresa.projetos.acessar', $projeto->id)->with('mensagem', 'Pagamento cancelado!');
        }
    }

    public function cancela_pagamento_anexo($id = null){
        $empresa = session()->get('empresa');
        $boleto = AnexoProjetoBoleto::where('id', $id)->first();
        $projeto = Projeto::where('id', $boleto->projeto_id)->first();

        if($empresa->id == $projeto->empresa_id){
            $boleto->st_boleto = "Aberto";
            $boleto->save();

            return redirect()->route('empresa.projetos.acessar', $projeto->id)->with('mensagem', 'Pagamento cancelado!');
        }
    }

    public function set_etapa(){
        $st_etapa = $_GET['st_etapa'];
        $etapa = Etapa::where('id', $_GET['etapa_id'])->first();
        $produto = Produto::where('id', $etapa->produto_id)->first();
        $orcamento = Orcamento::where('id', $produto->orcamento_id)->first();
        $empresa = session()->get('empresa');

        if($empresa->id == $orcamento->empresa_id){
            $etapa->st_etapa = $st_etapa;
            $etapa->save();

            $retorno['porcentagem_concluida'] = $this->calc_porcentagem_etapa_concluida($etapa->produto_id);
            $retorno['produto_id'] = $etapa->produto_id;
            echo json_encode($retorno);
        }
    }

    public function calc_porcentagem_etapa_concluida($produto_id){
        $etapas = Etapa::where('produto_id', $produto_id)->get();
        $qt_etapas = $etapas->count();
        $qt_concluidas = 0;

        foreach($etapas as $etapa){
            if($etapa->st_etapa == "Concluída"){
                $qt_concluidas++;
            }
        }

        return round($qt_concluidas * 100 / $qt_etapas);
    }

    public function adicionar_observacao(Request $request){
        $empresa = session()->get('empresa');
        $projeto = Projeto::where('id', $request->get('projeto_id'))->first();

        if($empresa->id == $projeto->empresa_id){
            $dados = $request->except('_token');
            $dados['dt_hr_obs'] = date("Y-m-d H:i:s");

            $obs = Observacao::create($dados);

            if($request->hasFile('arquivos')){
                foreach($request->file('arquivos') as $arquivo){
                    if($arquivo->isValid()){
                        $nm_arquivo = $arquivo->getClientOriginalName();
                        $caminho = "/projetos/$projeto->id/observacoes";
                        $arquivo->move(public_path($caminho), $nm_arquivo);

                        $dados_arq = [
                            'observacao_id' => $obs->id,
                            'nm_arquivo' => $nm_arquivo,
                            'ds_caminho' => $caminho,
                        ];

                        ObservacaoArquivo::create($dados_arq);
                    }
                }
            }

            return redirect()->route('empresa.projetos.acessar', $projeto->id)->with('mensagem', 'Observação Adicionado!');
        }
    }

    public function finalizar_projeto(Request $request){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $request->get('projeto_id'),
            'empresa_id' => $empresa->id,
        ];

        $projeto = Projeto::where($dados)->first();
        $projeto->st_projeto = "Finalizado";
        $projeto->save();

        return redirect()->route('empresa.projetos')->with('mensagem','Projeto Finalizado!');
    }

}
