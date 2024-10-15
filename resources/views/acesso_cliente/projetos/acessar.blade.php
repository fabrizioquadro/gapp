@extends('layout.cliente')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Projeto</h4>
</div>
@if($mensagem = Session::get('mensagem'))
    <div class="alert alert-success alert-dismissible mt-3" role="alert">
        {{ $mensagem }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-widget gap-4 mx-1 d-flex flex-nowrap" align='center' role="tablist">
                    <li class="nav-item" title='Informações Gerais do Projeto'>
                        <a href="javascript:void(0);" class="nav-link btn active d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-geral" aria-controls="navs-geral" aria-selected="true">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-secondary rounded">
                                    <i class="mdi mdi-information-outline"></i>
                                </div>
                            </div>
                            <span style='font-size: 10px'>Geral</span>
                        </a>
                    </li>
                    <li class="nav-item" title='Produtos Contratados'>
                        <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-produtos" aria-controls="navs-produtos" aria-selected="false">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-secondary rounded">
                                    <i class="mdi mdi-dolly"></i>
                                </div>
                            </div>
                            <span style='font-size: 10px'>Produtos</span>
                        </a>
                    </li>
                    <li class="nav-item" title='Financeiro'>
                        <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-financeiro" aria-controls="navs-financeiro" aria-selected="false">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-secondary rounded">
                                    <i class="mdi mdi-finance"></i>
                                </div>
                            </div>
                            <span style='font-size: 10px'>Financeiro</span>
                        </a>
                    </li>
                    <li class="nav-item" title='Etapas Concluídas'>
                        <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-etapas" aria-controls="navs-etapas" aria-selected="false">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-secondary rounded">
                                    <i class="mdi mdi-arrange-send-backward"></i>
                                </div>
                            </div>
                            <span style='font-size: 10px'>Etapas</span>
                        </a>
                    </li>
                    <li class="nav-item" title='Anexos'>
                        <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-anexos" aria-controls="navs-anexos" aria-selected="false">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-secondary rounded">
                                    <i class="mdi mdi-paperclip"></i>
                                </div>
                            </div>
                            <span style='font-size: 10px'>Anexos</span>
                        </a>
                    </li>
                    <li class="nav-item" title='Observaçoes'>
                        <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-andamento" aria-controls="navs-andamento" aria-selected="false">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-secondary rounded">
                                    <i class="mdi mdi-calendar-edit"></i>
                                </div>
                            </div>
                            <span style='font-size: 10px'>Observações</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <div class="tab-content p-0 ms-0 ms-sm-2">
                    <div class="tab-pane fade show active" id="navs-geral" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">Informações do Projeto</h4>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="earningReportsTabsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsTabsId">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <!-- aqui entra os dados do projeto -->
                        <div class="row">
                            <div class="col-md-6 form-group mt-3">
                                <label for="">Cliente:</label><br>
                                <b>{{ $projeto->cliente->nm_cliente }}</b>
                            </div>
                            <div class="col-md-3 form-group mt-3">
                                <label for="">Data Contratação:</label><br>
                                <b>{{ dataDbForm($projeto->dt_contratacao) }}</b>
                            </div>
                            <div class="col-md-3 form-group mt-3">
                                <label for="">Valor Total:</label><br>
                                <b>R$ {{ valorDbForm($projeto->vl_projeto) }}</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mt-3">
                                <label for="">Nome do Projeto:</label><br>
                                <b>{{ $projeto->nm_projeto }}</b>
                            </div>
                            <div class="col-md-3 form-group mt-3">
                                <label for="">Forma de Pagamento:</label><br>
                                <b>{{ $projeto->ds_forma_pagamento }}</b>
                            </div>
                            <div class="col-md-3 form-group mt-3">
                                <label for="">IP Contratante:</label><br>
                                <b>{{ $projeto->ip_contratante }}</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mt-3">
                                <label for="">Descrição da Forma de Pagamento:</label><br>
                                <b>{{ $projeto->obs_forma_pagamento }}</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mt-3">
                                <label for="">Descrição do Projeto:</label><br>
                                <b>{{ $projeto->ds_projeto }}</b>
                            </div>
                        </div>
                        @if($projeto->orcamento->arquivos->count() > 0)
                            <hr>
                            <h6 class="card-title mt-5">Anexos</h6>
                            <ul>
                                @foreach($projeto->orcamento->arquivos as $arquivo)
                                    <li>
                                        <a href="{{ asset('/public'.$arquivo->ds_caminho.'/'.$arquivo->nm_arquivo) }}" class="btn btn-text-secondary waves-effect waves-light" target='_blank'>{{ $arquivo->nm_arquivo }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if($projeto->caminho_contrato_pdf)
                            <hr>
                            <h6 class="card-title mt-5">Contrato</h6>
                            <embed type="application/pdf" width="100%" height="450px" id='embed_pdf' src='{{ asset("/public/contratos/$projeto->caminho_contrato_pdf") }}'>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="navs-produtos" role="tabpanel">
                        <div class="demo-inline-spacing mt-3">
                            <div class="list-group list-group-horizontal-md text-md-center">
                                @php
                                $active = 'active';
                                @endphp
                                @foreach($projeto->proj_produtos() as $prod)
                                    <a class="list-group-item list-group-item-action {{ $active }}" id="home-list-item_{{ $prod->produto->id }}" data-bs-toggle="list" href="#div_produto_{{ $prod->produto->id }}">{{ $prod->produto->nm_produto }}</a>
                                    @php
                                    $active = '';
                                    @endphp
                                @endforeach
                            </div>
                            <div class="tab-content px-0 mt-0">
                                @php
                                $active = 'active';
                                @endphp
                                @foreach($projeto->proj_produtos() as $prod)
                                    <div class="tab-pane fade show {{ $active }}" id="div_produto_{{ $prod->produto->id }}">
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="">Produto:</label><br>
                                                <b>{{ $prod->produto->nm_produto }}</b>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="">Valor:</label><br>
                                                <b>R$ {{ valorDbForm($prod->produto->vl_produto) }}</b>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="">Data de Entrega:</label><br>
                                                <b>{{ dataDbForm($prod->dt_entrega) }}</b>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="">Situação Produto:</label><br>
                                                <b>{{ $prod->situacao }}</b>
                                            </div>
                                        </div>
                                        @if($prod->produto->ds_produto)
                                        <div class="row mt-3">
                                            <div class="col-md-12 form-group">
                                                <label for="">Descrição do Item:</label><br>
                                                <b>R$ {{ $prod->produto->ds_produto }}</b>
                                            </div>
                                        </div>
                                        @endif
                                        @if($prod->produto->arquivos->count() > 0)
                                        <hr>
                                        <h6 class="card-title mt-5">Anexos</h6>
                                        <ul>
                                            @foreach($prod->produto->arquivos as $arquivo)
                                                <li>
                                                    <a href="{{ asset('/public'.$arquivo->ds_caminho.'/'.$arquivo->nm_arquivo) }}" class="btn btn-text-secondary waves-effect waves-light" target='_blank'>{{ $arquivo->nm_arquivo }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    @php
                                    $active = '';
                                    @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-financeiro" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">Financeiro</h4>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="earningReportsTabsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-light small fw-medium">Porcentagem Paga</div>
                            <div class="demo-vertical-spacing">
                                <div class="progress" style='height: 20px'>
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $porcentagem_paga }}%" aria-valuenow="{{ $porcentagem_paga }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $porcentagem_paga }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- aqui entra os dados do projeto -->
                        <h6 class="card-title mt-3">Pagamentos Projeto</h6>
                        @if($projeto->ds_forma_pagamento == "Cartão de Crédito")
                            <h5 class="card-title">Pagamento Cartão de Crédito</h5>
                            <p>{{ $projeto->obs_forma_pagamento }}</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Numero</th>
                                        <th>Vencimento</th>
                                        <th>Valor</th>
                                        <th>Situação</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projeto->boletos as $boleto)
                                        <tr>
                                            <td>{{ $boleto->nr_boleto }}</td>
                                            <td>{{ dataDbForm($boleto->dt_boleto) }}</td>
                                            <td>{{ valorDbForm($boleto->vl_boleto) }}</td>
                                            <td>{{ $boleto->st_boleto }}</td>
                                            <td>
                                                @if($boleto->st_boleto == "Aberto")
                                                    <form action="{{ route('cliente.projetos.financeiro.enviar_comprovante') }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="boleto_id" value="{{ $boleto->id }}">
                                                        <div class="button-wrapper" title='Enviar Comprovante'>
                                                            <label for="upload_b_{{ $boleto->id }}" class="btn btn-label-secondary waves-effect" tabindex="0">
                                                                <span class="mdi mdi-progress-upload"></span>
                                                                <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                                                <input type="file" onchange='submit()' name='arquivo' id="upload_b_{{ $boleto->id }}" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                                            </label>
                                                        </div>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        <h6 class="card-title mt-3">Pagamentos Anexos</h6>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Anexo</th>
                                    <th>Vencimento</th>
                                    <th>Forma Pagamento</th>
                                    <th>Valor</th>
                                    <th>Situação</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projeto->anexos as $anexo)
                                    @php
                                    $controle = '';
                                    if($anexo->st_anexo == "Aberto"){
                                        $dt_vencimento = "";
                                        $ds_forma_pagamento = "";
                                        $st_anexo = "Aberto";
                                    }
                                    elseif($anexo->ds_forma_pagamento == "Cartão de Crédito"){
                                        $dt_vencimento = dataDbForm($anexo->dt_contratacao);
                                        $ds_forma_pagamento = $anexo->ds_forma_pagamento;
                                        $st_anexo = "Pago";
                                    }
                                    else{
                                        $boleto = App\Models\AnexoProjetoBoleto::where('anexo_id', $anexo->id)->first();
                                        $dt_vencimento = dataDbForm($boleto->dt_boleto);
                                        $ds_forma_pagamento = "Pagamento Àvista";
                                        $st_anexo = $boleto->st_boleto;
                                        $controle = 'boleto';
                                        $boleto_id = $boleto->id;
                                    }
                                    @endphp
                                    <tr>
                                        <td>{{ $anexo->nm_anexo }}</td>
                                        <td>{{ $dt_vencimento }}</td>
                                        <td>{{ $ds_forma_pagamento }}</td>
                                        <td>{{ valorDbForm($anexo->vl_anexo) }}</td>
                                        <td>{{ $st_anexo }}</td>
                                        <td>
                                            @if($controle == 'boleto' && $boleto->st_boleto == "Aberto")
                                                <form action="{{ route('cliente.projetos.financeiro.enviar_comprovante_anexo') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="boleto_id" value="{{ $boleto->id }}">
                                                    <div class="button-wrapper" title='Enviar Comprovante'>
                                                        <label for="upload_{{ $boleto->id }}" class="btn btn-label-secondary waves-effect" tabindex="0">
                                                            <span class="mdi mdi-progress-upload"></span>
                                                            <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                                            <input type="file" onchange='submit()' name='arquivo' id="upload_{{ $boleto->id }}" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                                        </label>
                                                    </div>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="navs-etapas" role="tabpanel">
                        <div class="demo-inline-spacing mt-3">
                            <div class="list-group list-group-horizontal-md text-md-center">
                                @php
                                $active = 'active';
                                @endphp
                                @foreach($projeto->proj_produtos() as $prod)
                                    <a class="list-group-item list-group-item-action {{ $active }}" id="home-list-item_{{ $prod->produto->id }}" data-bs-toggle="list" href="#div_etapa_{{ $prod->produto->id }}">{{ $prod->produto->nm_produto }}</a>
                                    @php
                                    $active = '';
                                    @endphp
                                @endforeach
                            </div>
                            <div class="tab-content px-0 mt-0">
                                @php
                                $active = 'active';
                                @endphp
                                @foreach($projeto->proj_produtos() as $prod)
                                    <div class="tab-pane fade show {{ $active }}" id="div_etapa_{{ $prod->produto->id }}">
                                        <div class="d-flex justify-content-between mb-3">
                                            <h4 class="card-title">Etapas {{ $prod->produto->nm_produto }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="text-light small fw-medium">Porcentagem Concluída</div>
                                            <div class="demo-vertical-spacing">
                                                <div class="progress" style='height: 20px'>
                                                    <div class="progress-bar bg-primary" id="porcentagem_etapa_{{ $prod->produto->id }}" role="progressbar" style="width: {{ $array_etapas[$prod->produto->id] }}%" aria-valuenow="{{ $array_etapas[$prod->produto->id] }}" aria-valuemin="0" aria-valuemax="100">
                                                        {{ $array_etapas[$prod->produto->id] }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-group">
                                            @foreach($prod->produto->etapas as $etapa)
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    {{ $etapa->nm_etapa }}
                                                    @if($etapa->st_etapa == "Concluída")
                                                        <span class="badge rounded-pill bg-success">Concluída</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-secondary">Aberta</span>
                                                    @endif
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @php
                                    $active = '';
                                    @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-anexos" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">Anexos</h4>
                        </div>
                        <div class="table-responsive">
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Valor</th>
                                        <th>Forma de Pagamento</th>
                                        <th>Situação</th>
                                        <th>Contratação</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projeto->anexos as $anexo)
                                        <tr style="cursor: pointer" onclick="modal_acessar_anexo({{ $anexo->id }})">
                                            <td>{{ $anexo->nm_anexo }}</td>
                                            <td>{{ valorDbForm($anexo->vl_anexo) }}</td>
                                            <td>{{ $anexo->ds_forma_pagamento }}</td>
                                            <td>{{ $anexo->st_anexo }}</td>
                                            <td>{{ $anexo->dt_contratacao ? dataDbForm($anexo->dt_contratacao) : '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-andamento" role="tabpanel">
                        <h5 class="card-title mb-3">Linha do Tempo</h5>
                        <ul class="timeline pb-0 mb-0">
                            @foreach($projeto->observacoes as $obs)
                                @if($obs->tp_obs == "Pública")
                                    @php
                                    $classe = $obs->tp_obs == 'Pública' ? 'primary' : 'danger';
                                    $var = explode(' ', $obs->dt_hr_obs);
                                    $dt_hr_obs = dataDbForm($var[0])." ".$var[1];
                                    @endphp
                                    <li class="timeline-item timeline-item-transparent border-{{ $classe }}">
                                        <span class="timeline-point timeline-point-{{ $classe }}"></span>
                                        <div class="timeline-event">
                                            <div class="timeline-header">
                                                <h6 class="mb-0">{{ $obs->ds_obs }}</h6>
                                                <span class="text-muted">{{ $dt_hr_obs }}</span>
                                            </div>
                                            <ul>
                                                @foreach($obs->arquivos as $arquivo)
                                                    <li> <a href='{{ asset("/public/$arquivo->ds_caminho/$arquivo->nm_arquivo") }}' class="btn btn-text-secondary waves-effect waves-light" target="_blank">{{ $arquivo->nm_arquivo }}</a> </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ínicio áreas dos modais -->

<!-- Modal acessar Anexo -->
<script>
function modal_acessar_anexo(anexo_id){

    document.getElementById('acessar_anexo_id').value = anexo_id;
    document.getElementById('acessar_arquivos').style.display = 'none';
    $.getJSON(
        "{{ route('cliente.projetos.anexos.buscar') }}",
        {
            anexo_id : anexo_id
        },
        function(json){
            document.getElementById('embed_pdf_anexo').setAttribute('src', "/public/contratos/" + json.pdf);

            document.getElementById('caminho_contrato_pdf').value = json.pdf;
            document.getElementById('acessar_nm_anexo').innerHTML = json.nm_anexo;
            document.getElementById('acessar_ds_anexo').innerHTML = json.ds_anexo;
            document.getElementById('acessar_vl_anexo').innerHTML = json.vl_anexo;
            document.getElementById('acessar_ds_forma_pagamento').innerHTML = json.ds_forma_pagamento;

            if(json.arquivos == 'true'){
                document.getElementById('acessar_arquivos').innerHTML = json.html_view;
                document.getElementById('acessar_arquivos').style.display = 'block';
            }

            if(json.st_anexo == "Aberto"){
                document.getElementById('acessar_view_pagamento').style.display = 'block';
            }
            else{
                document.getElementById('acessar_view_pagamento').style.display = 'none';
            }

            const myModal = new bootstrap.Modal(document.getElementById('modal_acessar_anexo'));
            myModal.show();
        }
    );
}
</script>
<div class="modal fade" id="modal_acessar_anexo" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form class="modal-content">
            @csrf
            <input type="hidden" name="anexo_id" id='acessar_anexo_id'>
            <input type="hidden" name="caminho_contrato_pdf" id='caminho_contrato_pdf'>
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Acessar Anexo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-border-shadow-warning" style="height: 100%">
                            <div class="card-body">
                                <embed type="application/pdf" width="100%" height="100%" id='embed_pdf_anexo' src="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-border-shadow-success">
                            <div class="card-body">
                                <h6 class="card-title">Anexo</h6>
                                <div class="row">
                                    <div class="col-md-12 form-group mt-3">
                                        <label for="nm_anexo">Nome:</label><br>
                                        <b id='acessar_nm_anexo'></b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group mt-3">
                                        <label for="ds_anexo">Descrição</label><br>
                                        <b id='acessar_ds_anexo'></b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group mt-3">
                                        <label for="vl_anexo">Valor:</label><br>
                                        <b id='acessar_vl_anexo'></b>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="ds_forma_pagamento">Forma Pagamento:</label><br>
                                        <b id='acessar_ds_forma_pagamento'></b>
                                    </div>
                                </div>
                                <div id="acessar_arquivos" style='display:none'>

                                </div>
                            </div>
                        </div>
                        <div class="card mt-3 card-border-shadow-primary" id='acessar_view_pagamento'>
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
                                </div>
                                <hr>
                                <div id='div_credito'>
                                    <h6 class="card-title">Cartão de Crédito</h6>
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
                                                Finalize o contrato, faço o pagamento e envie o comprovante para darmos início ao anexo.
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
})
document.getElementById('forma_pagamento_boleto').addEventListener('click', ()=>{
    document.getElementById('div_credito').style.display = 'none';
    document.getElementById('div_boleto').style.display = 'block';
})

document.getElementById('btn_finalizar_cartao').addEventListener('click', ()=>{

    nr_cartao = document.getElementById('nr_cartao').value;
    nm_cartao = document.getElementById('nm_cartao').value;
    nr_codigo = document.getElementById('nr_codigo').value;
    vencimento_cartao = document.getElementById('vencimento_cartao').value;

    if(nr_cartao && nm_cartao && nr_codigo && vencimento_cartao){
        $.getJSON(
            "{{ route('cliente.projetos.anexos.fechar_anexo') }}",
            {
                ds_forma_pagamento : 'Cartão de Crédito',
                nr_cartao : nr_cartao,
                nm_cartao : nm_cartao,
                nr_codigo : nr_codigo,
                vencimento_cartao : vencimento_cartao,
                anexo_id : document.getElementById('acessar_anexo_id').value,
                caminho_contrato_pdf : document.getElementById('caminho_contrato_pdf').value
            },
            function(json){
                if(json.controle == 'true'){
                    alert('Anexo Contrado!');
                    window.location.href = "{{ route('cliente.projetos.acessar') }}/" + "{{ $projeto->id }}";
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
});

document.getElementById('btn_finalizar_avista').addEventListener('click', ()=>{

    $.getJSON(
        "{{ route('cliente.projetos.anexos.fechar_anexo') }}",
        {
            ds_forma_pagamento : 'Àvista',
            anexo_id : document.getElementById('acessar_anexo_id').value,
            caminho_contrato_pdf : document.getElementById('caminho_contrato_pdf').value
        },
        function(json){
            if(json.controle == 'true'){
                alert('Anexo Contrado!');
                window.location.href = "{{ route('cliente.projetos.acessar') }}/" + "{{ $projeto->id }}";
            }
            else{
                alert(json.erro);
            }
        }
    );
});

</script>
<!-- Fim áreas dos modais -->
@endsection
