<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Orcamento;
use App\Models\OrcamentoArquivo  AS ArqOrcamento;
use App\Models\OrcamentoProduto AS Produto;
use App\Models\OrcamentoProdutoArquivo AS ArqProduto;
use App\Models\OrcamentoProdutoEtapa AS ProdutoEtapa;
use App\Models\ModeloEtapa AS Modelo;

class OrcamentoEmpresaController extends Controller
{
    public function index(){
        $empresa = session()->get('empresa');
        $orcamentos = Orcamento::where('empresa_id', $empresa->id)->get();

        return view('acesso_empresa/orcamentos/index', compact('orcamentos'));
    }

    public function adicionar(){
        $empresa = session()->get('empresa');
        $clientes = Cliente::where('empresa_id', $empresa->id)->orderBy('nm_cliente')->get();
        $modelos = Modelo::where('empresa_id', $empresa->id)->orderBy('nm_modelo')->get();

        return view('acesso_empresa/orcamentos/adicionar', compact('clientes','modelos'));
    }

    public function insert(Request $request){
        $empresa = session()->get('empresa');

        $dados_orcamento = [
            'empresa_id' => $empresa->id,
            'cliente_id' => $request->get('cliente_id'),
            'titulo' => $request->get('titulo'),
            'descricao' => $request->get('descricao'),
            'validade' => $request->get('validade'),
            'st_orcamento' => 'Aberto',
            'desconto_avista' => $request->get('desconto_avista'),
            'parcelamento_cartao' => $request->get('parcelamento_cartao'),
            'parcelamento_entrada' => $request->get('parcelamento_entrada'),
            'vencimento_entrada' => $request->get('vencimento_entrada'),
            'parcelamento_vezes' => $request->get('parcelamento_vezes'),
            'entrega_entrada' => $request->get('entrega_entrada'),
            'entrega_vencimento' => $request->get('entrega_vencimento'),
        ];

        $orcamento = Orcamento::create($dados_orcamento);

        if($request->hasFile('arquivos')){
            foreach($request->file('arquivos') as $arquivo){
                if($arquivo->isValid()){
                    $nm_arquivo = $arquivo->getClientOriginalName();
                    $caminho = "/orcamentos/$orcamento->id/arquivos";
                    $arquivo->move(public_path($caminho), $nm_arquivo);

                    $dados_arq = [
                        'orcamento_id' => $orcamento->id,
                        'nm_arquivo' => $nm_arquivo,
                        'ds_caminho' => $caminho,
                    ];

                    ArqOrcamento::create($dados_arq);
                }
            }
        }

        //vamos cadastrar os items
        for($i=1 ; $i<=$request->get('contador_item') ; $i++){
            //vamos montar os dados
            $var = "nm_produto".$i;
            $nm_produto = $request->get($var);
            $var = "vl_produto".$i;
            $vl_produto = valorFormDb($request->get($var));
            $var = "dias_entrega".$i;
            $dias_entrega = $request->get($var);
            $var = "ds_produto".$i;
            $ds_produto = $request->get($var);

            if($nm_produto && $dias_entrega){
                //se entrar cadastramos o item
                $dados_item = [
                    'orcamento_id' => $orcamento->id,
                    'nm_produto' => $nm_produto,
                    'ds_produto' => $ds_produto,
                    'vl_produto' => $vl_produto,
                    'dias_entrega' => $dias_entrega,
                    'st_produto' => 'Aberto',
                ];

                $produto = Produto::create($dados_item);

                $var = "arquivos_item".$i;
                if($request->hasFile($var)){
                    foreach($request->file($var) as $arquivo){
                        if($arquivo->isValid()){
                            $nm_arquivo = $arquivo->getClientOriginalName();
                            $caminho = "/orcamentos/$orcamento->id/produtos/$produto->id/arquivos";
                            $arquivo->move(public_path($caminho), $nm_arquivo);

                            $dados_arq = [
                                'produto_id' => $produto->id,
                                'nm_arquivo' => $nm_arquivo,
                                'ds_caminho' => $caminho,
                            ];

                            ArqProduto::create($dados_arq);
                        }
                    }
                }

                //vamos analizar se veio etapas para este produto
                $var = "etapas".$i;
                $etapas = $request->get($var);
                if($etapas){
                    $etapas = json_decode($etapas);
                    foreach($etapas as $etapa){
                        $dados_etapa = [
                            'produto_id' => $produto->id,
                            'nm_etapa' => $etapa->value,
                            'st_etapa' => 'Aberta',
                        ];

                        ProdutoEtapa::create($dados_etapa);
                    }
                }
            }
        }

        //vamos verificar se há a necessidade de enviar email de aviso ao cliente
        if($request->get('enviar_email_cliente') == "sim"){
            $this->enviar_email_orcamento_cliente($orcamento);
        }

        return redirect()->route('empresa.orcamentos')->with('mensagem', "Orçamento Cadastrado!");
    }

    public function enviar_email_orcamento_cliente($orcamento){
        $cliente = Cliente::where('id', $orcamento->cliente_id)->first();
        $empresa = Empresa::where('id', $orcamento->empresa_id)->first();

        $mensagem = "
        <h4>Novo Orçamento</h4>
        <p>
            Foi cadastrado no sistema inteligente da empresa $empresa->nm_empresa um novo orçamento para você. <br>
            Acesse nosso <a href='".link_acesso_cliente()."' target='_blank'>portal </a> usando o seu email e sua senha  e verifique o orçamento.
        </p>
        ";

        enviarMail($cliente->ds_email,'Novo Orçamento Disponível', $mensagem);
    }

    public function acessar($id){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $id,
            'empresa_id' => $empresa->id,
        ];

        $orcamento = Orcamento::where($dados)->first();
        return view('acesso_empresa/orcamentos/acessar', compact('orcamento'));
    }

    public function update(Request $request){
        $orcamento = Orcamento::where('id', $request->get('orcamento_id'))->first();
        $orcamento->titulo = $request->get('titulo');
        $orcamento->descricao = $request->get('descricao');
        $orcamento->validade = $request->get('validade');
        $orcamento->validade = $request->get('validade');
        $orcamento->st_orcamento = $request->get('st_orcamento');

        $orcamento->save();

        if($request->hasFile('arquivos')){
            foreach($request->file('arquivos') as $arquivo){
                if($arquivo->isValid()){
                    $nm_arquivo = $arquivo->getClientOriginalName();
                    $caminho = "/orcamentos/$orcamento->id/arquivos";
                    $arquivo->move(public_path($caminho), $nm_arquivo);

                    $dados_arq = [
                        'orcamento_id' => $orcamento->id,
                        'nm_arquivo' => $nm_arquivo,
                        'ds_caminho' => $caminho,
                    ];

                    ArqOrcamento::create($dados_arq);
                }
            }
        }
        return redirect()->route('empresa.orcamentos.acessar', $orcamento->id)->with('mensagem', "Informações Básicas Editadas!");
    }

    public function delete_arquivo_orcamento($id = null){
        $empresa = session()->get('empresa');
        $arquivo = ArqOrcamento::where('id', $id)->first();
        $orcamento = Orcamento::where('id', $arquivo->orcamento_id)->first();

        if($orcamento->empresa_id == $empresa->id){
            $arquivo->delete();
            return redirect()->route('empresa.orcamentos.acessar', $orcamento->id)->with('mensagem', "Arquivo Excluído!");
        }
    }

    public function buscar_produto(){
        $produto_id = $_GET['produto_id'];
        $produto = Produto::where('id', $produto_id)->first();
        $orcamento = Orcamento::where('id', $produto->orcamento_id)->first();
        $empresa = session()->get('empresa');
        if($orcamento->empresa_id == $empresa->id){
            $retorno['produto_id'] = $produto->id;
            $retorno['nm_produto'] = $produto->nm_produto;
            $retorno['ds_produto'] = $produto->ds_produto;
            $retorno['dias_entrega'] = $produto->dias_entrega;
            $retorno['vl_produto'] = valorDbForm($produto->vl_produto);
            $retorno['st_produto'] = $produto->st_produto;

            $etapas = "";
            foreach($produto->etapas as $etapa){
                $etapas .= ' ,'.$etapa->nm_etapa;
            }
            $etapas = substr($etapas, 2);
            $retorno['etapas'] = $etapas;

            echo json_encode($retorno);
        }
    }

    public function update_produto(Request $request){
        $produto_id = $request->get('produto_id');
        $produto = Produto::where('id', $produto_id)->first();
        $orcamento = Orcamento::where('id', $produto->orcamento_id)->first();
        $empresa = session()->get('empresa');
        if($orcamento->empresa_id == $empresa->id){
            $produto->nm_produto = $request->get('nm_produto');
            $produto->ds_produto = $request->get('ds_produto');
            $produto->st_produto = $request->get('st_produto');
            $produto->dias_entrega = $request->get('dias_entrega');
            $produto->vl_produto = valorFormDb($request->get('vl_produto'));

            $produto->save();
            if($request->hasFile('arquivos')){
                foreach($request->file('arquivos') as $arquivo){
                    if($arquivo->isValid()){
                        $nm_arquivo = $arquivo->getClientOriginalName();
                        $caminho = "/orcamentos/$orcamento->id/produtos/$produto->id/arquivos";
                        $arquivo->move(public_path($caminho), $nm_arquivo);

                        $dados_arq = [
                            'produto_id' => $produto->id,
                            'nm_arquivo' => $nm_arquivo,
                            'ds_caminho' => $caminho,
                        ];

                        ArqProduto::create($dados_arq);
                    }
                }
            }
            //vamos verificar as etapas
            ProdutoEtapa::where('produto_id', $produto->id)->delete();
            $etapas = $request->get('etapas');
            if($etapas){
                $etapas = json_decode($etapas);
                foreach($etapas as $etapa){
                    $dados_etapa = [
                        'produto_id' => $produto->id,
                        'nm_etapa' => $etapa->value,
                        'st_etapa' => 'Aberta',
                    ];

                    ProdutoEtapa::create($dados_etapa);
                }
            }

            return redirect()->route('empresa.orcamentos.acessar', $orcamento->id)->with('mensagem', "Item Editado!");
        }
    }

    public function delete_arquivo_produto($id = null){
        $arquivo = ArqProduto::where('id', $id)->first();
        $produto = Produto::where('id', $arquivo->produto_id)->first();
        $orcamento = Orcamento::where('id', $produto->orcamento_id)->first();
        $empresa = session()->get('empresa');
        if($orcamento->empresa_id == $empresa->id){
            $arquivo->delete();
            return redirect()->route('empresa.orcamentos.acessar', $orcamento->id)->with('mensagem', "Arquivo Excluído!");
        }
    }

    public function excluir($id){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $id,
            'empresa_id' => $empresa->id,
        ];
        $orcamento = Orcamento::where($dados)->first();

        return view('acesso_empresa/orcamentos/excluir', compact('orcamento'));
    }

    public function delete(Request $request){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $request->get('orcamento_id'),
            'empresa_id' => $empresa->id,
        ];

        $orcamento = Orcamento::where($dados)->first();
        if($orcamento){
            foreach($orcamento->produtos as $produto){
                ArqProduto::where('produto_id', $produto->id)->delete();
                ProdutoEtapa::where('produto_id', $produto->id)->delete();
                $produto->delete();
            }

            ArqOrcamento::where('orcamento_id', $orcamento->id)->delete();
            $orcamento->delete();

            return redirect()->route('empresa.orcamentos')->with('mensagem','Orcamento Excluído!');
        }
    }

    public function enviar_email_cliente($id){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $id,
            'empresa_id' => $empresa->id,
        ];
        $orcamento = Orcamento::where($dados)->first();
        $this->enviar_email_orcamento_cliente($orcamento);

        return redirect()->route('empresa.orcamentos')->with('mensagem', 'Email enviado ao cliente');
    }

    public function update_forma_pagamento(Request $request){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $request->get('orcamento_id'),
            'empresa_id' => $empresa->id,
        ];

        $orcamento = Orcamento::where($dados)->first();

        $orcamento->desconto_avista = $request->get('desconto_avista');
        $orcamento->parcelamento_cartao = $request->get('parcelamento_cartao');
        $orcamento->parcelamento_entrada = $request->get('parcelamento_entrada');
        $orcamento->vencimento_entrada = $request->get('vencimento_entrada');
        $orcamento->parcelamento_vezes = $request->get('parcelamento_vezes');
        $orcamento->entrega_entrada = $request->get('entrega_entrada');
        $orcamento->entrega_vencimento = $request->get('entrega_vencimento');

        $orcamento->save();
        return redirect()->route('empresa.orcamentos.acessar', $orcamento->id)->with('mensagem', "Forma de Pagamento Editada!");
    }

    public function busca_modelo_etapa(){
        $empresa = session()->get('empresa');
        $dados = [
            'id' => $_GET['modelo_id'],
            'empresa_id' => $empresa->id,
        ];

        $modelo = Modelo::where($dados)->first();
        $etapas = "";
        foreach($modelo->etapas as $etapa){
            $etapas .= ','.$etapa->nm_etapa;
        }

        $retorno['etapas'] = $etapas;
        echo json_encode($retorno);
    }

}
