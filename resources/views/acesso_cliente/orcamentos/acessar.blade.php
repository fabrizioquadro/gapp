@extends('layout.cliente')

@section('conteudo')
    @php
    $var = explode(' ', $orcamento->created_at);
    $dt_orcamento = $var[0];
    $dt_validade = date('Y-m-d', strtotime("+$orcamento->validade days", strtotime($dt_orcamento)));
    $dt_hoje = date('Y-m-d');
    if(strtotime($dt_validade) >= strtotime($dt_hoje)){
        $situacao = "Aberto";
    }
    else{
        $situacao = "Vencido";
    }
    @endphp
    <div class="d-flex justify-content-between">
        <h4 class="card-title">Orçamento</h4>
    </div>
    @if($mensagem = Session::get('mensagem'))
        <div class="alert alert-success alert-dismissible mt-3" role="alert">
            {{ $mensagem }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <hr>
    <div class="card card-border-shadow-primary">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h6 class="card-title">Informações Básicas</h6>
            </div>
            <div class="row">
                <div class="col-md-8 form-group mt-3">
                    <label for="">Título:</label><br>
                    <b>{{ $orcamento->titulo }}</b>
                </div>
                <div class="col-md-4 form-group mt-3">
                    <label for="">Situação:</label><br>
                    <b>{{ $situacao }}</b>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group mt-3">
                    <label for="">Data Orçamento:</label><br>
                    <b>{{ dataDbForm($dt_orcamento) }}</b>
                </div>
                <div class="col-md-4 form-group mt-3">
                    <label for="">Validade:</label><br>
                    <b>{{ dataDbForm($dt_validade) }}</b>
                </div>
                <div class="col-md-4 form-group mt-3">
                    <label for="">Valor Total:</label><br>
                    <b>R$ {{ valorDbForm($orcamento->get_valor_orcamento()) }}</b>
                </div>
            </div>
            @if($orcamento->descricao)
                <div class="row">
                    <div class="col-md-12 form-group mt-3">
                        <label for="">Descrição:</label><br>
                        <b>{{ $orcamento->descricao }}</b>
                    </div>
                </div>
            @endif
            @if($orcamento->arquivos->count() > 0)
            <h6 class="card-title mt-5">Anexos</h6>
            <ul>
                @foreach($orcamento->arquivos as $arquivo)
                    <li>
                        <div class="d-flex justify-content-between mb-2">
                            <a href="{{ asset('/public'.$arquivo->ds_caminho.'/'.$arquivo->nm_arquivo) }}" class="btn btn-text-secondary waves-effect waves-light" target='_blank'>{{ $arquivo->nm_arquivo }}</a>
                        </div>
                    </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
    @foreach($orcamento->produtos as $produto)
        <div class="card card-border-shadow-warning mt-3">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="card-title">{{ $produto->nm_produto }}</h6>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="">Valor:</label><br>
                        <b>R$ {{ valorDbForm($produto->vl_produto) }}</b>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Entrega (dias):</label><br>
                        <b>{{ $produto->dias_entrega }}</b>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Situação:</label><br>
                        <b>{{ $produto->st_produto }}</b>
                    </div>
                </div>
                @if($produto->ds_produto)
                <div class="row mt-3">
                    <div class="col-md-12 form-group">
                        <label for="">Descrição do Item:</label><br>
                        <b>{{ $produto->ds_produto }}</b>
                    </div>
                </div>
                @endif
                @if($produto->arquivos->count() > 0)
                <h6 class="card-title mt-5">Anexos</h6>
                <ul>
                    @foreach($produto->arquivos as $arquivo)
                        <li>
                            <div class="d-flex justify-content-between mb-2">
                                <a href="{{ asset('/public'.$arquivo->ds_caminho.'/'.$arquivo->nm_arquivo) }}" class="btn btn-text-secondary waves-effect waves-light" target='_blank'>{{ $arquivo->nm_arquivo }}</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    @endforeach
    <div class="card card-border-shadow-success mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h6 class="card-title">Pagamento</h6>
            </div>
            @if($orcamento->desconto_avista)
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <b>Pagamento Ávista:</b><br>
                            Desconto de {{ $orcamento->desconto_avista }}% para pagamentos àvista.
                        </p>
                    </div>
                </div>
                <hr>
            @endif
            @if($orcamento->parcelamento_cartao)
                <div class="row mt-4">
                    <div class="col-md-12">
                        <p>
                            <b>Cartão de Crédito:</b><br>
                            Parcele em até {{ $orcamento->parcelamento_cartao }} X no cartão de crédito
                        </p>
                    </div>
                </div>
                <hr>
            @endif
            @if($orcamento->parcelamento_vezes)
                <div class="row mt-4">
                    <div class="col-md-12">
                        <p>
                            <b>Entrada + Sado Devedor:</b><br>
                            Entrada de {{ $orcamento->parcelamento_entrada }}% + {{ $orcamento->parcelamento_vezes }}X iguais no boleto ou pix.<br>
                            Pagamento da entrada até o dia {{ dataDbForm($orcamento->vencimento_entrada) }}.
                        </p>
                    </div>
                </div>
                <hr>
            @endif
            @if($orcamento->entrega_entrada)
                @php
                $saldo = 100 - $orcamento->entrega_entrada;
                @endphp
                <div class="row mt-4">
                    <div class="col-md-12">
                        <p>
                            <b>Entrada + Entrega:</b><br>
                            Entrada de {{ $orcamento->entrega_entrada }}% + {{ $saldo }}% na entrega.<br>
                            Pagamento da entrada até o dia {{ dataDbForm($orcamento->entrega_vencimento) }}.
                        </p>
                    </div>
                </div>
                <hr>
            @endif
            @if($controle_contratacao == 'true')
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modal_fechar_projeto" class="btn btn-success">Contratar Projeto</button>
                    </div>
                </div>
            @endif
        </div>
    </div>

<!-- Ínicio áreas dos modais -->
@if($controle_contratacao == 'true')
    <!-- Modal -->
    <div class="modal fade" id="modal_fechar_projeto" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <form action="" class="modal-content" method="post">
                @csrf
                <input type="hidden" name="orcamento_id" value="{{ $orcamento->id }}">
                <input type="hidden" name="caminho_contrato_pdf" id="caminho_contrato_pdf">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Contratar Projeto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-border-shadow-warning" style="height: 100%">
                                <div class="card-body">
                                    <embed type="application/pdf" width="100%" height="100%" id='embed_pdf' src="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-border-shadow-success">
                                <div class="card-body">
                                    <h6 class="card-title">Produtos/Serviços à Conntratar</h6>
                                    @foreach($orcamento->produtos as $produto)
                                        @if($produto->st_produto == "Aberto")
                                            <dl class="row gy-2">
                                                <dt class="col-6 h6 mb-0">
                                                    <div class="form-check form-check-success">
                                                        <input class="form-check-input input_items" onclick='calcula_fechamento()' type="checkbox" value="{{ $produto->id }}" id="custom{{ $produto->id }}" checked="">
                                                        <label class="form-check-label" for="custom{{ $produto->id }}">{{ $produto->nm_produto }}</label>
                                                    </div>
                                                </dt>
                                                <dd class="col-6 text-end mb-0">R$ {{ valorDbForm($produto->vl_produto) }}</dd>
                                            </dl>
                                        @endif
                                    @endforeach
                                    <dl class="row gy-2">
                                        <dt class="col-6 h6 mb-0"><h6 style="font-weight: 900">Total</h6></dt>
                                        <dd class="col-6 text-end mb-0"><h6 style="font-weight: 900" id='pagamento_items_valor_total'>R$ {{ valorDbForm($orcamento->get_valor_orcamento()) }}</h6</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="card mt-3 card-border-shadow-primary">
                                <div class="card-body">
                                    <h6 class="card-title">Forma de Pagamento</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-md-0 mb-2 mt-2">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customRadioIcon1">
                                                    <span class="custom-option-body">
                                                        <i class="mdi mdi-credit-card-check-outline"></i>
                                                        <span class="custom-option-title">Cartão de Crédito</span>
                                                    </span>
                                                    <input name="forma_pagamento" class="form-check-input" type="radio" value="credito" id="forma_pagamento_credito" checked />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-md-0 mb-2 mt-2">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customRadioIcon1">
                                                    <span class="custom-option-body">
                                                        <i class="mdi mdi-barcode"></i>
                                                        <span class="custom-option-title">Pagamento Àvista Pix</span>
                                                    </span>
                                                    <input name="forma_pagamento" class="form-check-input" type="radio" value="boleto" id="forma_pagamento_boleto" />
                                                </label>
                                            </div>
                                        </div>
                                        @if($orcamento->parcelamento_vezes)
                                            <div class="col-md-6 mb-md-0 mb-2 mt-2">
                                                <div class="form-check custom-option custom-option-icon">
                                                    <label class="form-check-label custom-option-content" for="customRadioIcon1">
                                                        <span class="custom-option-body">
                                                            <i class="mdi mdi-percent-box-outline"></i>
                                                            <span class="custom-option-title">Parcelamento Direto</span>
                                                        </span>
                                                        <input name="forma_pagamento" class="form-check-input" type="radio" value="parcelado" id="forma_pagamento_parcelado" />
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                        @if($orcamento->entrega_entrada)
                                            <div class="col-md-6 mb-md-0 mb-2 mt-2">
                                                <div class="form-check custom-option custom-option-icon">
                                                    <label class="form-check-label custom-option-content" for="customRadioIcon1">
                                                        <span class="custom-option-body">
                                                            <i class="mdi mdi-check-circle-outline"></i>
                                                            <span class="custom-option-title">Entrada + Saldo na Entrega</span>
                                                        </span>
                                                        <input name="forma_pagamento" class="form-check-input" type="radio" value="entrega" id="forma_pagamento_entrega" />
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <hr>
                                    <div id='div_credito'>
                                        <h6 class="card-title">Cartão de Crédito</h6>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="form-floating form-floating-outline">
                                                    <select required id="nr_parcelas_cartao" class="select2 form-select">
                                                        <option></option>
                                                    </select>
                                                    <label for="nr_parcelas_cartao">Número de vezes:</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="form-floating form-floating-outline">
                                                    <input required class="form-control" type="text" id="nr_cartao" placeholder="Número do Cartão:" maxlength="16" />
                                                    <label for="nr_cartao">Número do Cartão:</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mt-3">
                                                <div class="form-floating form-floating-outline">
                                                    <input required class="form-control" type="text" id="nm_cartao" placeholder="Nome no Cartão:" />
                                                    <label for="nm_cartao">Nome no Cartão:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-3">
                                                <div class="form-floating form-floating-outline">
                                                    <input required class="form-control" type="text" id="nr_codigo" placeholder="Código Segurança:" />
                                                    <label for="nr_codigo">Código Segurança:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-3">
                                                <div class="form-floating form-floating-outline">
                                                    <input required class="form-control" type="text" id="vencimento_cartao" placeholder="Vencimento:" maxlength="5" onkeypress="formatar('##/##', this)"/>
                                                    <label for="vencimento_cartao">Vencimento:</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4" align='right'>
                                            <button type="button" id='btn_finalizar_cartao' class="btn btn-secondary me-2">Finalizar Contrato</button>
                                        </div>
                                    </div>
                                    <div id='div_boleto' style='display:none'>
                                        <h6 class="card-title">Pagamento Àvista Pix</h6>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <p>
                                                    Pix: <b>{{ $config->tipo_pix }}</b><br>
                                                    Chave: <b>{{ $config->chave_pix }}</b><br><br>
                                                    Finalize o contrato, faço o pagamento e envie o comprovante para darmos início do projeto.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <h5 class="card-title" id='pagamento_avista_pix'></h5>
                                            </div>
                                        </div>
                                        <div class="mt-4" align='right'>
                                            <button type="button" id='btn_finalizar_avista' class="btn btn-secondary me-2">Finalizar Contrato</button>
                                        </div>
                                    </div>
                                    @if($orcamento->parcelamento_vezes)
                                        <div id='div_parcelamento' style='display:none'>
                                            <h6 class="card-title">Parcelamento</h6>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <p>
                                                        Pix: <b>{{ $config->tipo_pix }}</b><br>
                                                        Chave: <b>{{ $config->chave_pix }}</b>
                                                    </p>
                                                    <p id='descricao_parcelamento'></p>
                                                    <p>
                                                        Informe o numero de vezes que fará o saldo, finalize o contrato, faço o pagamento através do pix e envie o comprovante para darmos início do projeto.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="form-floating form-floating-outline">
                                                        <select required id="nr_parcelas_parcelamento" class="select2 form-select">
                                                            <option></option>
                                                        </select>
                                                        <label for="nr_parcelas_parcelamento">Número de vezes:</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4" align='right'>
                                                <button type="button" id='btn_finalizar_parcelamento' class="btn btn-secondary me-2">Finalizar Contrato</button>
                                            </div>
                                        </div>
                                    @endif
                                    @if($orcamento->entrega_entrada)
                                        <div id='div_entrega' style='display:none'>
                                            <h6 class="card-title">Entrada + Saldo na Entrega</h6>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <p>
                                                        Pix: <b>{{ $config->tipo_pix }}</b><br>
                                                        Chave: <b>{{ $config->chave_pix }}</b>
                                                    </p>
                                                    <p id='descricao_entrega'></p>
                                                    <p>
                                                        Finalize o contrato, faço o pagamento através do pix e envie o comprovante para darmos início do projeto.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="mt-4" align='right'>
                                                <button type="button" id='btn_finalizar_entrega' class="btn btn-secondary me-2">Finalizar Contrato</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('forma_pagamento_credito').addEventListener('click', ()=>{
        document.getElementById('div_credito').style.display = 'block';
        document.getElementById('div_boleto').style.display = 'none';
        document.getElementById('div_parcelamento').style.display = 'none';
        document.getElementById('div_entrega').style.display = 'none';
    })
    document.getElementById('forma_pagamento_boleto').addEventListener('click', ()=>{
        document.getElementById('div_credito').style.display = 'none';
        document.getElementById('div_boleto').style.display = 'block';
        document.getElementById('div_parcelamento').style.display = 'none';
        document.getElementById('div_entrega').style.display = 'none';
    })
    document.getElementById('forma_pagamento_parcelado').addEventListener('click', ()=>{
        document.getElementById('div_credito').style.display = 'none';
        document.getElementById('div_boleto').style.display = 'none';
        document.getElementById('div_parcelamento').style.display = 'block';
        document.getElementById('div_entrega').style.display = 'none';
    })
    document.getElementById('forma_pagamento_entrega').addEventListener('click', ()=>{
        document.getElementById('div_credito').style.display = 'none';
        document.getElementById('div_boleto').style.display = 'none';
        document.getElementById('div_parcelamento').style.display = 'none';
        document.getElementById('div_entrega').style.display = 'block';
    })
    </script>

    <!-- Fim áreas dos modais -->
    <script>
    function calcula_fechamento(){
        items = '';
        controle = false;
        inputs = document.querySelectorAll('input.input_items');
        [].forEach.call(inputs, function(input) {
            if(input.checked == true){
                items = items + ',' + input.value;
                controle = true;
            }
        });

        if(controle){
            $.getJSON(
                "{{ route('cliente.orcamentos.monta_pagamento') }}",
                {
                    orcamento_id : {{ $orcamento->id }},
                    items : items
                },
                function(json){
                    document.getElementById('pagamento_items_valor_total').innerHTML = json.soma_total_view;
                    document.getElementById('nr_parcelas_cartao').innerHTML = json.parcelas_cartao;
                    document.getElementById('pagamento_avista_pix').innerHTML = json.pagamento_avista_pix;
                    @if($orcamento->parcelamento_vezes)
                        document.getElementById('nr_parcelas_parcelamento').innerHTML = json.parcelas_parcelamento;
                        document.getElementById('descricao_parcelamento').innerHTML = json.descricao_parcelamento;
                    @endif
                    @if($orcamento->entrega_entrada)
                        document.getElementById('descricao_entrega').innerHTML = json.descricao_entrega;
                    @endif
                    document.getElementById('embed_pdf').setAttribute('src', "/public/contratos/" + json.pdf);
                    document.getElementById('caminho_contrato_pdf').value = json.pdf;
                }
            );
        }
        else{
            alert('É necessario escolher pelo menos um item.');
            document.getElementById('pagamento_items_valor_total').innerHTML = 'R$ 0,00';
        }
    }

    window.addEventListener('load',()=>{
        calcula_fechamento()
    });

    document.getElementById('btn_finalizar_cartao').addEventListener('click', ()=>{
        //vamos verificar se há algum item selecionado
        items = '';
        controle = false;
        inputs = document.querySelectorAll('input.input_items');
        [].forEach.call(inputs, function(input) {
            if(input.checked == true){
                items = items + ',' + input.value;
                controle = true;
            }
        });

        if(controle){
            nr_cartao = document.getElementById('nr_cartao').value;
            nm_cartao = document.getElementById('nm_cartao').value;
            nr_codigo = document.getElementById('nr_codigo').value;
            vencimento_cartao = document.getElementById('vencimento_cartao').value;
            nr_parcelas = document.getElementById('nr_parcelas_cartao').value;

            if(nr_cartao && nm_cartao && nr_codigo && vencimento_cartao){
                $.getJSON(
                    "{{ route('cliente.orcamentos.fechar_projeto') }}",
                    {
                        ds_forma_pagamento : 'Cartão de Crédito',
                        nr_cartao : nr_cartao,
                        nm_cartao : nm_cartao,
                        nr_codigo : nr_codigo,
                        vencimento_cartao : vencimento_cartao,
                        nr_parcelas : nr_parcelas,
                        items : items,
                        orcamento_id : {{ $orcamento->id }},
                        caminho_contrato_pdf : document.getElementById('caminho_contrato_pdf').value
                    },
                    function(json){
                        if(json.controle == 'true'){
                            alert('Projeto Contrado!');
                            window.location.href = "{{ route('cliente.projetos') }}";
                        }
                        else{
                            alert(json.erro);
                        }
                    }
                );
            }
            else{
                alert('É necessário preencher todos os dados solicitados!');
            }
        }
        else{
            alert('É necessário escolher pelo menos 1 Produto/Serviço');
        }
    });

    document.getElementById('btn_finalizar_avista').addEventListener('click', ()=>{
        //vamos verificar se há algum item selecionado
        items = '';
        controle = false;
        inputs = document.querySelectorAll('input.input_items');
        [].forEach.call(inputs, function(input) {
            if(input.checked == true){
                items = items + ',' + input.value;
                controle = true;
            }
        });

        if(controle){
            $.getJSON(
                "{{ route('cliente.orcamentos.fechar_projeto') }}",
                {
                    ds_forma_pagamento : 'Àvista',
                    items : items,
                    orcamento_id : {{ $orcamento->id }},
                    caminho_contrato_pdf : document.getElementById('caminho_contrato_pdf').value
                },
                function(json){
                    if(json.controle == 'true'){
                        alert('Projeto Contrado!');
                        window.location.href = "{{ route('cliente.projetos') }}";
                    }
                    else{
                        alert(json.erro);
                    }
                }
            );
        }
        else{
            alert('É necessário escolher pelo menos 1 Produto/Serviço');
        }
    });

    document.getElementById('btn_finalizar_parcelamento').addEventListener('click', ()=>{
        //vamos verificar se há algum item selecionado
        items = '';
        controle = false;
        inputs = document.querySelectorAll('input.input_items');
        [].forEach.call(inputs, function(input) {
            if(input.checked == true){
                items = items + ',' + input.value;
                controle = true;
            }
        });

        if(controle){
            $.getJSON(
                "{{ route('cliente.orcamentos.fechar_projeto') }}",
                {
                    ds_forma_pagamento : 'Parcelamento',
                    items : items,
                    orcamento_id : {{ $orcamento->id }},
                    nr_parcelas : document.getElementById('nr_parcelas_parcelamento').value,
                    caminho_contrato_pdf : document.getElementById('caminho_contrato_pdf').value
                },
                function(json){
                    if(json.controle == 'true'){
                        alert('Projeto Contrado!');
                        window.location.href = "{{ route('cliente.projetos') }}";
                    }
                    else{
                        alert(json.erro);
                    }
                }
            );
        }
        else{
            alert('É necessário escolher pelo menos 1 Produto/Serviço');
        }
    });

    document.getElementById('btn_finalizar_entrega').addEventListener('click', ()=>{
        //vamos verificar se há algum item selecionado
        items = '';
        controle = false;
        inputs = document.querySelectorAll('input.input_items');
        [].forEach.call(inputs, function(input) {
            if(input.checked == true){
                items = items + ',' + input.value;
                controle = true;
            }
        });

        if(controle){
            $.getJSON(
                "{{ route('cliente.orcamentos.fechar_projeto') }}",
                {
                    ds_forma_pagamento : 'Entrega',
                    items : items,
                    orcamento_id : {{ $orcamento->id }},
                    caminho_contrato_pdf : document.getElementById('caminho_contrato_pdf').value
                },
                function(json){
                    if(json.controle == 'true'){
                        alert('Projeto Contrado!');
                        window.location.href = "{{ route('cliente.projetos') }}";
                    }
                    else{
                        alert(json.erro);
                    }
                }
            );
        }
        else{
            alert('É necessário escolher pelo menos 1 Produto/Serviço');
        }
    });



    </script>
@endif
@endsection
