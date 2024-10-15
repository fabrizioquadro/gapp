<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projeto;
use App\Models\ProjetoBoleto;
use App\Models\AnexoProjeto;
use App\Models\AnexoProjetoBoleto;
use LifenPag\Asaas\V3\Entities\Payment as PaymentEntity;
use LifenPag\Asaas\V3\Domains\Customer as CustomerDomain;
use LifenPag\Asaas\V3\Client;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Empresa;
use App\Models\EmpresaConfiguracao AS Config;

class ProjetoClienteController extends Controller
{
    public function index(){
        $cliente = session()->get('cliente');
        $projetos = Projeto::where('cliente_id', $cliente->id)->get();

        return view('acesso_cliente/projetos/index', compact('projetos'));
    }

    public function acessar($id = null){
        $cliente = session()->get('cliente');
        $dados = [
            'id' => $id,
            'cliente_id' => $cliente->id,
        ];
        $projeto = Projeto::where($dados)->first();
        $empresa = Empresa::where('id', $cliente->empresa_id)->first();
        $config = Config::where('empresa_id', $empresa->id)->first();

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
            $controller = new ProjetoEmpresaController();
            $array_etapas[$prod->produto->id] = $controller->calc_porcentagem_etapa_concluida($prod->produto->id);
        }

        return view('acesso_cliente/projetos/acessar', compact('projeto','config','porcentagem_paga','array_etapas'));
    }

    public function buscar_anexo(){
        $anexo_id = $_GET['anexo_id'];
        $anexo = AnexoProjeto::where('id', $anexo_id)->first();

        $cliente = session()->get('cliente');

        if($cliente->id == $anexo->cliente_id){
            $retorno['anexo_id'] = $anexo->id;
            $retorno['nm_anexo'] = $anexo->nm_anexo;
            $retorno['ds_anexo'] = $anexo->ds_anexo;
            $retorno['vl_anexo'] = valorDbForm($anexo->vl_anexo);
            $retorno['ds_forma_pagamento'] = $anexo->ds_forma_pagamento;
            $retorno['st_anexo'] = $anexo->st_anexo;

            //vamos buscar os arquivos
            $retorno['arquivos'] = 'false';
            $html_view = "<hr>
                    <ul>
                    <h6 class='card-title'>Arquivos</h6>
                    ";

            foreach($anexo->arquivos as $arquivo){
                $retorno['arquivos'] = 'true';
                $html_view.= "
                <li>
                    <a href='/public/$arquivo->ds_caminho/$arquivo->nm_arquivo' class='btn btn-text-secondary waves-effect waves-light' target='_blank'>$arquivo->nm_arquivo</a>
                </li>
                ";
            }
            $html_view .= "</ul>";

            $retorno['html_view'] = $html_view;
            if($anexo->st_anexo == "Aberto"){
                $retorno['pdf'] = $this->gera_pdf_contrato($anexo);
            }
            else{
                $retorno['pdf'] = $anexo->caminho_contrato_pdf;
            }

            echo json_encode($retorno);
        }
    }

    public function gera_pdf_contrato($anexo){
        $cliente = session()->get('cliente');
        if($cliente->id == $anexo->cliente->id){
            $empresa = Empresa::where('id', $cliente->empresa_id)->first();
            $config = Config::where('empresa_id', $empresa->id)->first();

            $dados_cliente = "$cliente->nm_cliente, $cliente->tp_cliente CPF/CNPJ: $cliente->nr_cpf, endereço $cliente->ds_endereco $cliente->nr_endereco $cliente->ds_complemento $cliente->ds_bairro $cliente->nm_cidade $cliente->ds_uf";
            $dados_empresa = "$empresa->nm_empresa, $empresa->tp_empresa CPF/CNPJ: $empresa->nr_cnpj, endereço $empresa->ds_endereco $empresa->nr_endereco $empresa->ds_complemento $empresa->ds_bairro $empresa->nm_cidade $empresa->ds_uf";

            $dia_escrito = data_escrita(date('Y-m-d'));

            $contrato = $config->modelo_contrato_anexo;
            $contrato = str_replace('%dados_cliente%', $dados_cliente, $contrato);
            $contrato = str_replace('%dados_empresa%', $dados_empresa, $contrato);
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
            $contrato = str_replace('%nm_anexo%', $anexo->nm_anexo, $contrato);
            $contrato = str_replace('%ds_anexo%', $anexo->ds_anexo, $contrato);
            $contrato = str_replace('%vl_anexo%', 'R$'.valorDbForm($anexo->vl_anexo), $contrato);

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

            $nm_contrato = 'Anexo_'.$cliente->nm_cliente."_".date('Ymdhis').".pdf";
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

    public function fechar_anexo(){
        $ds_forma_pagamento = $_GET['ds_forma_pagamento'];
        $caminho_contrato_pdf = $_GET['caminho_contrato_pdf'];
        $anexo = AnexoProjeto::where('id', $_GET['anexo_id'])->first();
        $cliente = session()->get('cliente');
        $config = Config::where('empresa_id', $cliente->empresa_id)->first();

        $asaas_client = $config->asaas_client;
        $asaas_method = $config->asaas_method;

        Client::connect($asaas_client, $asaas_method);

        //vamos verificar o valor total do projeto
        $soma_total = $anexo->vl_anexo;

        if($ds_forma_pagamento == "Cartão de Crédito"){
            $nr_parcelas = 1;

            if(!$config || !$config->asaas_client || !$config->asaas_method){
                $retorno['controle'] = "false";
                $retorno['erro'] = "A empresa não possui integração com o gawtey de pagamento.";
                echo json_encode($retorno);
                exit();
            }

            $cliente->verifica_id_customer_asaas();

            $descricao = "Anexo de Projeto, cod: $anexo->id";
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
                    $obs_forma_pagamento = "Pagamento Cartão de crédito . Id_pagamento Asaas = $payment_created->id";
                    $anexo->dt_contratacao = date('Y-m-d');
                    $anexo->ds_forma_pagamento = $ds_forma_pagamento;
                    $anexo->obs_forma_pagamento = $obs_forma_pagamento;
                    $anexo->st_anexo = 'Contratado';
                    $anexo->caminho_contrato_pdf = $caminho_contrato_pdf;
                    $anexo->save();

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
            $anexo->dt_contratacao = date('Y-m-d');
            $anexo->ds_forma_pagamento = $ds_forma_pagamento;
            $anexo->obs_forma_pagamento = $obs_forma_pagamento;
            $anexo->st_anexo = 'Contratado';
            $anexo->caminho_contrato_pdf = $caminho_contrato_pdf;
            $anexo->save();

            //vamos adicionar o boleto do anexo
            $dados_boleto = [
                'anexo_id' => $anexo->id,
                'projeto_id' => $anexo->projeto_id,
                'cliente_id' => $anexo->cliente_id,
                'nr_boleto' => '1',
                'dt_boleto' => date('Y-m-d'),
                'vl_boleto' => $anexo->vl_anexo,
                'st_boleto' => 'Aberto',
            ];

            AnexoProjetoBoleto::create($dados_boleto);

            $retorno['controle'] = "true";
            echo json_encode($retorno);
        }
    }

    public function enviar_comprovante(Request $request){
        $cliente = session()->get('cliente');
        $boleto = ProjetoBoleto::where('id', $request->get('boleto_id'))->first();

        if($cliente->id == $boleto->cliente_id){
            if($request->hasFile('arquivo') && $request->file('arquivo')->isValid()){
                $arquivo = $request->arquivo;
                $extensao = $arquivo->extension();

                $nm_arquivo = $boleto->id.".".$extensao;

                $request->arquivo->move(public_path('/comprovantes'), $nm_arquivo);

                $boleto->arquivo_comprovante = $nm_arquivo;

                $boleto->save();

                return redirect()->route('cliente.projetos.acessar', $boleto->projeto_id)->with('mensagem','Comprovante Enviado!');
            }
        }
    }

    public function enviar_comprovante_anexo(Request $request){
        $cliente = session()->get('cliente');
        $boleto = AnexoProjetoBoleto::where('id', $request->get('boleto_id'))->first();

        if($cliente->id == $boleto->cliente_id){
            if($request->hasFile('arquivo') && $request->file('arquivo')->isValid()){
                $arquivo = $request->arquivo;
                $extensao = $arquivo->extension();

                $nm_arquivo = $boleto->id.".".$extensao;

                $request->arquivo->move(public_path('/comprovantes/anexos'), $nm_arquivo);

                $boleto->arquivo_comprovante = $nm_arquivo;

                $boleto->save();

                return redirect()->route('cliente.projetos.acessar', $boleto->projeto_id)->with('mensagem','Comprovante Enviado!');
            }
        }
    }

}
