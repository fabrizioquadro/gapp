<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\Orcamento;
use App\Models\OrcamentoProduto AS Produto;
use App\Models\EmpresaConfiguracao AS Config;
use App\Models\Projeto;
use App\Models\ProjetoProduto;
use App\Models\ProjetoBoleto;
use LifenPag\Asaas\V3\Entities\Payment as PaymentEntity;
use LifenPag\Asaas\V3\Domains\Customer as CustomerDomain;
use LifenPag\Asaas\V3\Client;
use Dompdf\Dompdf;
use Dompdf\Options;

class OrcamentoClienteController extends Controller
{
    public function index(){
        $cliente = session()->get('cliente');
        $orcamentos = Orcamento::where('cliente_id', $cliente->id)->get();

        return view('acesso_cliente/orcamentos/index', compact('orcamentos'));
    }

    public function acessar($id){
        $cliente = session()->get('cliente');
        $dados = [
            'id' => $id,
            'cliente_id' => $cliente->id,
        ];

        $config = Config::where('empresa_id', $cliente->empresa_id)->first();

        $orcamento = Orcamento::where($dados)->first();

        //vamos verificar se possui algum item a ser contrato esse orçamento
        $dados_controle = [
            'orcamento_id' => $orcamento->id,
            'st_produto' => 'Aberto',
        ];

        $controle_contratacao = Produto::where($dados_controle)->count() > 0 ? 'true' : 'false';

        return view('acesso_cliente/orcamentos/acessar', compact('orcamento','config','controle_contratacao'));
    }

    public function monta_pagamento(){
        $cliente = session()->get('cliente');
        $dados = [
            'id' => $_GET['orcamento_id'],
            'cliente_id' => $cliente->id,
        ];

        $orcamento = Orcamento::where($dados)->first();

        $controle = true;
        $soma_total = 0;
        if($orcamento){
            $items = substr($_GET['items'], 1);
            $items = explode(',', $items);

            foreach($items as $item){
                $produto = Produto::where('id', $item)->first();
                $controle = $produto->orcamento_id == $orcamento->id ? true : false;

                $soma_total += $produto->vl_produto;
            }
        }
        else{
            $controle = false;
        }

        $retorno['controle'] = $controle ? 'true' : 'false';
        $retorno['soma_total'] = $soma_total;
        $retorno['soma_total_view'] = "R$ ".valorDbForm($soma_total);

        //vamos montar o parcelamento do cartao
        if($orcamento->desconto_avista){
            $desconto = round($soma_total * $orcamento->desconto_avista / 100 , 2);
            $valor = round($soma_total - $desconto, 2);
            $html = "<option value='1'>Pagamento Ávista R$ ".valorDbForm($valor)."</option>";
            $pagamento_avista_pix = "Pagamento Ávista R$".valorDbForm($valor);
        }
        else{
            $html = "<option value='1'>1 X de R$ ".valorDbForm($valor)."</option>";
            $pagamento_avista_pix = "Pagamento Ávista R$".valorDbForm($valor);
        }

        for($i=2 ; $i<=$orcamento->parcelamento_cartao ; $i++){
            $valor = round($soma_total / $i, 2);
            $html .= "<option value='$i'>$i X de R$ ".valorDbForm($valor)."</option>";
        }

        $retorno['parcelas_cartao'] = $html;
        $retorno['pagamento_avista_pix'] = $pagamento_avista_pix;

        //vamos verificar o parcelamento
        $entrada = round($soma_total * $orcamento->parcelamento_entrada / 100, 2);
        $saldo = round($soma_total - $entrada, 2);
        $parcelas = round($saldo / $orcamento->parcelamento_vezes , 2);
        $p = "
        Entrada de <b>R$ ".valorDbForm($entrada)."</b> para o data de <b>".dataDbForm($orcamento->vencimento_entrada)."</b><br>
        Saldo em até <b>$orcamento->parcelamento_vezes de R$ ".valorDbForm($parcelas)."</b>.
        ";

        $html = "";
        for($i=1 ; $i<=$orcamento->parcelamento_vezes ; $i++){
            $parcela = round($saldo / $i , 2);
            $html .= "<option value='$i'>$i X de R$ ".valorDbForm($parcela)."</option>";
        }
        $retorno['descricao_parcelamento'] = $p;
        $retorno['parcelas_parcelamento'] = $html;

        //vamos ver os dados da entrada + entrega
        $entrada = round($soma_total * $orcamento->entrega_entrada / 100, 2);
        $saldo = round($soma_total - $entrada, 2);
        $p = "
        Entrada de <b>R$ ".valorDbForm($entrada)."</b> para o data de <b>".dataDbForm($orcamento->entrega_vencimento)."</b><br>
        Saldo de <b>R$ ".valorDbForm($saldo)."</b> para pagamento na entrega dos produtos/serviços.
        ";
        $retorno['descricao_entrega'] = $p;
        $retorno['pdf'] = $this->gera_pdf_proposta($orcamento, $items);

        echo json_encode($retorno);
    }

    public function fechar_projeto(){
        $ds_forma_pagamento = $_GET['ds_forma_pagamento'];
        $caminho_contrato_pdf = $_GET['caminho_contrato_pdf'];
        $orcamento = Orcamento::where('id', $_GET['orcamento_id'])->first();
        $cliente = session()->get('cliente');
        $config = Config::where('empresa_id', $cliente->empresa_id)->first();

        $asaas_client = $config->asaas_client;
        $asaas_method = $config->asaas_method;

        Client::connect($asaas_client, $asaas_method);

        //vamos verificar o valor total do projeto
        $soma_total = 0;
        $items = substr($_GET['items'], 1);
        $items = explode(',', $items);
        foreach($items as $item){
            $produto = Produto::where('id', $item)->first();
            $soma_total += $produto->vl_produto;
        }

        if($ds_forma_pagamento == "Cartão de Crédito"){
            $nr_parcelas = $_GET['nr_parcelas'];

            if(!$config || !$config->asaas_client || !$config->asaas_method){
                $retorno['controle'] = "false";
                $retorno['erro'] = "A empresa não possui integração com o gawtey de pagamento.";
                echo json_encode($retorno);
                exit();
            }

            $cliente->verifica_id_customer_asaas();

            if($orcamento->desconto_avista && $nr_parcelas == 1){
                $desconto = round($soma_total * $orcamento->desconto_avista / 100 , 2);
                $soma_total = round($soma_total - $desconto, 2);
            }

            $descricao = "Venda de Projeto";
            $var = explode('/',$_GET['vencimento_cartao']);
            $mes_vencimento = $var[0];
            $ano_vencimento = $var[1];
            $telefone = "992118977";
            $ddd = "55";
            $nr_endereco = '1285';
            $nr_cep = '96300000';
            $cpf = str_replace('.','',$cliente->nr_cpf);
            $cpf = str_replace('-','',$cpf);

            $vl_parcelas = round($soma_total / $nr_parcelas, 2);

            $payment = new PaymentEntity();
            $payment->customer = $cliente->custon_id_asaas;
            $payment->billingType = 'CREDIT_CARD';
            $payment->value = $soma_total;
            $payment->installmentCount = $nr_parcelas;
            $payment->installmentValue = $vl_parcelas;
            $payment->description = $descricao;
            $payment->dueDate = (new \DateTime())->format('Y-m-d');
            $payment->creditCardHolderName = $_GET['nm_cartao'];
            $payment->creditCardNumber = $_GET['nr_cartao'];
            $payment->creditCardExpiryMonth = $mes_vencimento;
            $payment->creditCardExpiryYear = $ano_vencimento;
            $payment->creditCardCcv = $_GET['nr_codigo'];
            $payment->creditCardHolderFullName = $_GET['nm_cartao'];
            $payment->creditCardHolderEmail = $cliente->ds_email;
            $payment->creditCardHolderCpfCnpj = $cpf;
            $payment->creditCardHolderMobilePhone = $telefone;
            $payment->creditCardHolderMobilePhoneDDD = $ddd;
            $payment->creditCardHolderAddressNumber = $nr_endereco;
            $payment->creditCardHolderPostalCode = $nr_cep;

            try{
                $payment_created = $payment->create();
                if($payment_created->status == "CONFIRMED"){
                    //vamos criar o projeto e os demais campos
                    $obs_forma_pagamento = "Pagamento Cartão de crédito em $nr_parcelas parcela(s). Id_pagamento Asaas = $payment_created->id";
                    $this->registrar_projeto($orcamento, $cliente, 'Cartão de Crédito', $caminho_contrato_pdf, $items, $soma_total, $_SERVER['REMOTE_ADDR'], $obs_forma_pagamento);
                    $retorno['controle'] = "true";
                    echo json_encode($retorno);
                }
                else{
                    $retorno['controle'] = "false";
                    $retorno['erro'] = "Cobrança Não Aprovada!";
                    echo json_encode($retorno);
                    exit();
                }
            }catch (\Exception $e) {
                $retorno['controle'] = "false";
                $retorno['erro'] = "<h3>Erro:</h3>Desculpe o transtorno, mas aconteceu um erro na sua solicitação<br>Exceção capturada: <br>',  ".$e->getMessage();
                echo json_encode($retorno);
                exit();
            }
        }
        elseif($ds_forma_pagamento == "Àvista"){
            $obs_forma_pagamento = "Pagamento Ávista";

            if($orcamento->desconto_avista){
                $desconto = round($soma_total * $orcamento->desconto_avista / 100 , 2);
                $soma_total = round($soma_total - $desconto, 2);
            }

            $this->registrar_projeto($orcamento, $cliente, 'Àvista', $caminho_contrato_pdf, $items, $soma_total, $_SERVER['REMOTE_ADDR'], $obs_forma_pagamento);
            $retorno['controle'] = "true";
            echo json_encode($retorno);
        }
        elseif($ds_forma_pagamento == "Parcelamento"){
            $nr_parcelas = $_GET['nr_parcelas'];
            $obs_forma_pagamento = "Pagamento Parcelado: Entrada + saldo dividido em $nr_parcelas";

            $this->registrar_projeto($orcamento, $cliente, 'Parcelamento Direto', $caminho_contrato_pdf, $items, $soma_total, $_SERVER['REMOTE_ADDR'], $obs_forma_pagamento, $nr_parcelas);
            $retorno['controle'] = "true";
            echo json_encode($retorno);
        }
        elseif($ds_forma_pagamento == "Entrega"){
            $obs_forma_pagamento = "Entrada, saldo devedor pago na entrega dos produtos/serviços.";

            $this->registrar_projeto($orcamento, $cliente, 'Entrada + Saldo na Entrega', $caminho_contrato_pdf, $items, $soma_total, $_SERVER['REMOTE_ADDR'], $obs_forma_pagamento);
            $retorno['controle'] = "true";
            echo json_encode($retorno);
        }
    }

    public function registrar_projeto($orcamento, $cliente, $ds_forma_pagamento, $caminho_contrato_pdf, $items, $soma_total, $ip_contratante, $obs_forma_pagamento, $nr_parcelas = null){
        //vamos registrar o Projeto
        $dados = [
            'orcamento_id' => $orcamento->id,
            'empresa_id' => $orcamento->empresa_id,
            'cliente_id' => $cliente->id,
            'nm_projeto' => $orcamento->titulo,
            'ds_projeto' => $orcamento->descricao,
            'dt_contratacao' => date('Y-m-d'),
            'vl_projeto' => $soma_total,
            'ds_forma_pagamento' => $ds_forma_pagamento,
            'obs_forma_pagamento' => $obs_forma_pagamento,
            'ip_contratante' => $ip_contratante,
            'caminho_contrato_pdf' => $caminho_contrato_pdf,
        ];
        $projeto = Projeto::create($dados);

        //vamos adicionar os itens ao projeto
        $dias_entrega = 0;
        foreach($items as $item){
            $produto = Produto::where('id', $item)->first();

            if($produto->dias_entrega > $dias_entrega){
                $dias_entrega = $produto->dias_entrega;
            }

            $dt_entrega = date('Y-m-d', strtotime("+$produto->dias_entrega days", strtotime($projeto->dt_contratacao)));

            $dados = [
                'projeto_id' => $projeto->id,
                'produto_id' => $produto->id,
                'dt_entrega' => $dt_entrega,
                'situacao' => 'Aberto',
            ];

            ProjetoProduto::create($dados);
            $produto->st_produto = 'Contratado';
            $produto->save();
        }

        //vamos preecher os boletos
        if($ds_forma_pagamento == "Àvista"){
            $dados = [
                'projeto_id' => $projeto->id,
                'cliente_id' => $cliente->id,
                'nr_boleto' => '1',
                'dt_boleto' => date('Y-m-d'),
                'vl_boleto' => $soma_total,
                'st_boleto' => 'Aberto',
            ];

            ProjetoBoleto::create($dados);
        }
        elseif($ds_forma_pagamento == "Parcelamento Direto"){
            $entrada = round($soma_total * $orcamento->parcelamento_entrada / 100, 2);
            $saldo = round($soma_total - $entrada, 2);
            $parcelas = round($saldo / $nr_parcelas , 2);

            //vamos adicionar a entrada
            $dados = [
                'projeto_id' => $projeto->id,
                'cliente_id' => $cliente->id,
                'nr_boleto' => '1',
                'dt_boleto' => $orcamento->vencimento_entrada,
                'vl_boleto' => $entrada,
                'st_boleto' => 'Aberto',
            ];

            ProjetoBoleto::create($dados);
            $data = $orcamento->vencimento_entrada;

            for($i=1 ; $i<=$nr_parcelas ; $i++){
                $data = date('Y-m-d', strtotime('+1 month', strtotime($data)));
                $j = $i+1;

                $dados = [
                    'projeto_id' => $projeto->id,
                    'cliente_id' => $cliente->id,
                    'nr_boleto' => $j,
                    'dt_boleto' => $data,
                    'vl_boleto' => $parcelas,
                    'st_boleto' => 'Aberto',
                ];
                ProjetoBoleto::create($dados);
            }
        }
        elseif($ds_forma_pagamento == "Entrada + Saldo na Entrega"){
            $entrada = round($soma_total * $orcamento->entrega_entrada / 100, 2);
            $saldo = round($soma_total - $entrada, 2);

            //vamos adicionar a entrada
            $dados = [
                'projeto_id' => $projeto->id,
                'cliente_id' => $cliente->id,
                'nr_boleto' => '1',
                'dt_boleto' => $orcamento->entrega_vencimento,
                'vl_boleto' => $entrada,
                'st_boleto' => 'Aberto',
            ];

            ProjetoBoleto::create($dados);

            $data = date('Y-m-d', strtotime("+$dias_entrega days", strtotime($orcamento->entrega_vencimento)));

            $dados = [
                'projeto_id' => $projeto->id,
                'cliente_id' => $cliente->id,
                'nr_boleto' => '2',
                'dt_boleto' => $data,
                'vl_boleto' => $saldo,
                'st_boleto' => 'Aberto',
            ];
            ProjetoBoleto::create($dados);
        }
    }

    public function gera_pdf_proposta($orcamento, $items){
        $empresa = Empresa::where('id', $orcamento->empresa_id)->first();
        $cliente = Cliente::where('id', $orcamento->cliente_id)->first();
        $config = Config::where('empresa_id', $empresa->id)->first();

        //vamos montar os macros do contrato
        $dados_cliente = "$cliente->nm_cliente, $cliente->tp_cliente CPF/CNPJ: $cliente->nr_cpf, endereço $cliente->ds_endereco $cliente->nr_endereco $cliente->ds_complemento $cliente->ds_bairro $cliente->nm_cidade $cliente->ds_uf";
        $dados_empresa = "$empresa->nm_empresa, $empresa->tp_empresa CPF/CNPJ: $empresa->nr_cnpj, endereço $empresa->ds_endereco $empresa->nr_endereco $empresa->ds_complemento $empresa->ds_bairro $empresa->nm_cidade $empresa->ds_uf";
        $dias_entrega = 0;
        $lista_produtos = "
        <table class='table' style='width: 100%'>
            <thead>
                <tr>
                    <td><b>Produto/Serviço</b></td>
                    <td><b>Descrição</b></td>
                    <td><b>Valor</b></td>
                    <td><b>Entrega (dias)</b></td>
                </tr>
            </thead>
            <tbody>";
            foreach($items as $item){
                $produto = Produto::where('id', $item)->first();
                if($produto->dias_entrega > $dias_entrega){
                    $dias_entrega = $produto->dias_entrega;
                }
                $lista_produtos .= "
                <tr>
                    <td>$produto->nm_produto</td>
                    <td>$produto->ds_produto</td>
                    <td>R$".valorDbForm($produto->vl_produto)."</td>
                    <td>$produto->dias_entrega</td>
                </tr>
                ";
            }
            $lista_produtos .= "
            </tbody>
        </table>
        ";

        $condicoes_pagamento = "
        <ul>";
            if($orcamento->desconto_avista){
                $condicoes_pagamento .= "<li>Desconto de $orcamento->desconto_avista % para pagamentos àvista.</li>";
            }

            if($orcamento->parcelamento_cartao){
                $condicoes_pagamento .= "<li>Parcelado em até $orcamento->parcelamento_cartao vezes no cartão de crédito</li>";
            }

            if($orcamento->parcelamento_vezes){
                $condicoes_pagamento .= "<li>Entrada de $orcamento->parcelamento_entrada% + $orcamento->parcelamento_vezes vezes.</li>";
            }

            if($orcamento->entrega_entrada){
                $condicoes_pagamento .= "<li>Entrada de $orcamento->entrega_entrada%, restante na entrega.</li>";
            }
        $condicoes_pagamento .="
        </ul>
        ";

        $dia_escrito = data_escrita(date('Y-m-d'));

        $contrato = $config->modelo_contrato;
        $contrato = str_replace('%dados_cliente%', $dados_cliente, $contrato);
        $contrato = str_replace('%dados_empresa%', $dados_empresa, $contrato);
        $contrato = str_replace('%lista_produtos%', $lista_produtos, $contrato);
        $contrato = str_replace('%dias_entrega%', $dias_entrega, $contrato);
        $contrato = str_replace('%condicoes_pagamento%', $condicoes_pagamento, $contrato);
        $contrato = str_replace('%data_escrito%', $dia_escrito, $contrato);
        $contrato = str_replace('%nm_cliente%', $cliente->nm_cliente, $contrato);
        $contrato = str_replace('%tp_cliente%', $cliente->tp_cliente, $contrato);
        $contrato = str_replace('%cliente_cpf%', $cliente->nr_cpf, $contrato);
        $contrato = str_replace('%cliente_email%', $cliente->ds_email, $contrato);
        $contrato = str_replace('%cliente_endereco%', $cliente->ds_endereco, $contrato);
        $contrato = str_replace('%cliente_numero%', $cliente->nr_endereco, $contrato);
        $contrato = str_replace('%cliente_complemento%', $cliente->ds_complemento, $contrato);
        $contrato = str_replace('%cliente_bairro%', $cliente->ds_bairro, $contrato);
        $contrato = str_replace('%cliente_cidade%', $cliente->nm_cidade, $contrato);
        $contrato = str_replace('%cliente_uf%', $cliente->ds_uf, $contrato);
        $contrato = str_replace('%cliente_cep%', $cliente->nr_cep, $contrato);
        $contrato = str_replace('%cliente_telefone%', $cliente->nr_tel." ".$cliente->nr_cel, $contrato);
        $contrato = str_replace('%nm_empresa%', $empresa->nm_empresa, $contrato);
        $contrato = str_replace('%tp_empresa%', $empresa->tp_empresa, $contrato);
        $contrato = str_replace('%empresa_cnpj%', $empresa->nr_cnpj, $contrato);
        $contrato = str_replace('%empresa_email%', $empresa->ds_email, $contrato);
        $contrato = str_replace('%empresa_endereco%', $empresa->ds_endereco, $contrato);
        $contrato = str_replace('%empresa_numero%', $empresa->nr_endereco, $contrato);
        $contrato = str_replace('%empresa_complemento%', $empresa->ds_complemento, $contrato);
        $contrato = str_replace('%empresa_bairro%', $empresa->ds_bairro, $contrato);
        $contrato = str_replace('%empresa_cidade%', $empresa->nm_cidade, $contrato);
        $contrato = str_replace('%empresa_uf%', $empresa->ds_uf, $contrato);
        $contrato = str_replace('%empresa_cep%', $empresa->nr_cep, $contrato);
        $contrato = str_replace('%empresa_telefone%', $empresa->nr_tel." ".$empresa->nr_cel, $contrato);

        $html = "
        <!doctype html>
        <html lang='pt'>
        <head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
        <title>CaT</title>
        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@100;300;400;500;700;900&display=swap' rel='stylesheet'>
        </head>
        <body>
            <div class='container'>
                $contrato
            </div>
        </body>
        </html>
        ";

        $nm_contrato = $cliente->nm_cliente."_".date('Ymdhis').".pdf";
        $nm_arquivo = public_path("/contratos/$nm_contrato");
        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents($nm_arquivo, $output);
        return $nm_contrato;
    }
}
