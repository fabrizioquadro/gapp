@extends('layout.empresa')

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
                    <li class="nav-item" title='Finalizar Projeto'>
                        <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-fechamento" aria-controls="navs-fechamento" aria-selected="false">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-secondary rounded">
                                    <i class="mdi mdi-progress-close"></i>
                                </div>
                            </div>
                            <span style='font-size: 10px'>Finalizar</span>
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
                                                @if($boleto->arquivo_comprovante)
                                                    <a title='Comprovante de Pagamento' href='{{ asset("/public/comprovantes/$boleto->arquivo_comprovante") }}' class="btn btn-icon btn-label-secondary waves-effect" target='_blank'><span class="mdi mdi-receipt-text-check"></span></a>
                                                @endif
                                                @if($boleto->st_boleto == "Aberto")
                                                    <button title='Confirmar Pagamento' onclick="confirmar_pagamento_boleto({{ $boleto->id }})" type="button" class="btn btn-icon btn-label-success waves-effect">
                                                        <span class="mdi mdi-check-bold"></span>
                                                    </button>
                                                @endif
                                                @if($boleto->st_boleto == "Pago")
                                                    <button title='Cancelar Pagamento' onclick="cancelar_pagamento_boleto({{ $boleto->id }})" type="button" class="btn btn-icon btn-label-danger waves-effect">
                                                        <span class="mdi mdi-close-box-outline"></span>
                                                    </button>
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
                                    }
                                    @endphp
                                    <tr>
                                        <td>{{ $anexo->nm_anexo }}</td>
                                        <td>{{ $dt_vencimento }}</td>
                                        <td>{{ $ds_forma_pagamento }}</td>
                                        <td>{{ valorDbForm($anexo->vl_anexo) }}</td>
                                        <td>{{ $st_anexo }}</td>
                                        <td>
                                            @if($controle == 'boleto')
                                                @if($boleto->arquivo_comprovante)
                                                    <a title='Comprovante de Pagamento' href='{{ asset("/public/comprovantes/anexos/$boleto->arquivo_comprovante") }}' class="btn btn-icon btn-label-secondary waves-effect" target='_blank'><span class="mdi mdi-receipt-text-check"></span></a>
                                                @endif
                                                @if($boleto->st_boleto == "Aberto")
                                                    <button title='Confirmar Pagamento' onclick="confirmar_pagamento_boleto_anexo({{ $boleto->id }})" type="button" class="btn btn-icon btn-label-success waves-effect">
                                                        <span class="mdi mdi-check-bold"></span>
                                                    </button>
                                                @endif
                                                @if($boleto->st_boleto == "Pago")
                                                    <button title='Cancelar Pagamento' onclick="cancelar_pagamento_boleto_anexo({{ $boleto->id }})" type="button" class="btn btn-icon btn-label-danger waves-effect">
                                                        <span class="mdi mdi-close-box-outline"></span>
                                                    </button>
                                                @endif
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
                                                        <div class="form-check form-check-success">
                                                            <input class="form-check-input" type="checkbox" onclick="salva_etapa(this, {{ $etapa->id }})" value="Concluída"  @if($etapa->st_etapa == 'Concluída') checked @endif>
                                                        </div>
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
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="earningReportsTabsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsTabsId">
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal_adicionar_anexo" href="javascript:void(0);">Adicionar Anexo</a>
                                </div>
                            </div>
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
                                        <tr>
                                            <td>{{ $anexo->nm_anexo }}</td>
                                            <td>{{ valorDbForm($anexo->vl_anexo) }}</td>
                                            <td>{{ $anexo->ds_forma_pagamento }}</td>
                                            <td>{{ $anexo->st_anexo }}</td>
                                            <td>{{ $anexo->dt_contratacao ? dataDbForm($anexo->dt_contratacao) : '' }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn p-0" type="button" id="earningReportsTabsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsTabsId">
                                                        <a class="dropdown-item" onclick='modal_editar_anexo({{ $anexo->id }})' href="javascript:void(0);">Editar</a>
                                                        <a class="dropdown-item" onclick='excluir_anexo({{ $anexo->id }})' href="javascript:void(0);">Excluir</a>
                                                        <a class="dropdown-item" onclick='modal_visualizar_anexo({{ $anexo->id }})' href="javascript:void(0);">Visualizar</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-andamento" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">Observações</h4>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="earningReportsTabsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsTabsId">
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal_adicionar_observacao" href="javascript:void(0);">Adicionar Observação</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-3">Linha do Tempo</h5>
                        <ul class="timeline pb-0 mb-0">
                            @foreach($projeto->observacoes as $obs)
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
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="navs-fechamento" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">Finalizar Projeto</h4>
                        </div>
                        <form action="{{ route('empresa.projetos.finalizar') }}" method="post">
                            @csrf
                            <input type="hidden" name="projeto_id" value='{{ $projeto->id }}'>
                            <p>Tem certeza que deseja finalizar este projeto?</p>
                            <div class="row">
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-danger me-2">Finalizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ínicio áreas dos modais -->

<!-- Modal adicionar Observação -->
<div class="modal fade" id="modal_adicionar_observacao" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('empresa.projetos.observacao.adicionar') }}" class="modal-content" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="projeto_id" value="{{ $projeto->id }}">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Adicionar Observação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-floating form-floating-outline">
                            <textarea required class="form-control h-px-100" id="ds_obs" name='ds_obs' placeholder="Observação:"></textarea>
                            <label for="ds_obs">Observação:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-floating form-floating-outline">
                            <select required id="tp_obs" name='tp_obs' class="select2 form-select">
                                <option value="Pública">Pública</option>
                                <option value="Privada">Privada</option>
                            </select>
                            <label for="ds_forma_pagamento">Tipo:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="file" id="arquivos" name="arquivos[]" multiple placeholder="Anexos:"/>
                            <label for="arquivos">Anexos:</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-secondary waves-effect waves-light">Salvar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal adicionar anexo -->
<div class="modal fade" id="modal_adicionar_anexo" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('empresa.projetos.anexos.adicionar') }}" class="modal-content" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="projeto_id" value="{{ $projeto->id }}">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Adicionar Anexo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input required class="form-control" type="text" id="nm_anexo" name="nm_anexo" placeholder="Nome:"/>
                            <label for="nm_anexo">Nome:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="ds_anexo" name='ds_anexo' placeholder="Descrição"></textarea>
                            <label for="ds_anexo">Descrição</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input required class="form-control" type="text" id="vl_anexo" name="vl_anexo" placeholder="Valor:" onkeypress="return(MascaraMoeda(this,'.',',',event))"/>
                            <label for="vl_anexo">Valor:</label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-floating form-floating-outline">
                            <select required id="ds_forma_pagamento" name='ds_forma_pagamento' class="select2 form-select">
                                <option value=""></option>
                                <option value="Cartão de Crédito">Cartão de Crédito</option>
                                <option value="Pix">Pix</option>
                                <option value="Ambas">Ambas</option>
                            </select>
                            <label for="ds_forma_pagamento">Forma Pagamento:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="file" id="arquivos" name="arquivos[]" multiple placeholder="Anexos:"/>
                            <label for="arquivos">Anexos:</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-secondary waves-effect waves-light">Salvar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Anexo -->
<script>
function modal_editar_anexo(anexo_id){
    document.getElementById('editar_arquivos').style.display = 'none';
    $.getJSON(
        "{{ route('empresa.projetos.anexos.buscar') }}",
        {
            anexo_id : anexo_id
        },
        function(json){
            document.getElementById('editar_anexo_id').value = json.anexo_id;
            document.getElementById('editar_nm_anexo').value = json.nm_anexo;
            document.getElementById('editar_ds_anexo').value = json.ds_anexo;
            document.getElementById('editar_vl_anexo').value = json.vl_anexo;
            document.getElementById('editar_ds_forma_pagamento').value = json.ds_forma_pagamento;
            if(json.arquivos == 'true'){
                document.getElementById('editar_arquivos').innerHTML = json.html;
                document.getElementById('editar_arquivos').style.display = 'block';
            }

            const myModal = new bootstrap.Modal(document.getElementById('modal_editar_anexo'));
            myModal.show();
        }
    );
}
</script>
<div class="modal fade" id="modal_editar_anexo" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('empresa.projetos.anexos.update') }}" class="modal-content" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="anexo_id" id='editar_anexo_id'>
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Editar Anexo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input required class="form-control" type="text" name="nm_anexo" placeholder="Nome:" id='editar_nm_anexo'/>
                            <label for="nm_anexo">Nome:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" name='ds_anexo' placeholder="Descrição" id='editar_ds_anexo'></textarea>
                            <label for="ds_anexo">Descrição</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input required class="form-control" type="text" name="vl_anexo" placeholder="Valor:" id='editar_vl_anexo' onkeypress="return(MascaraMoeda(this,'.',',',event))"/>
                            <label for="vl_anexo">Valor:</label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-floating form-floating-outline">
                            <select required name='ds_forma_pagamento'id='editar_ds_forma_pagamento' class="select2 form-select">
                                <option value=""></option>
                                <option value="Cartão de Crédito">Cartão de Crédito</option>
                                <option value="Pix">Pix</option>
                                <option value="Ambas">Ambas</option>
                            </select>
                            <label for="ds_forma_pagamento">Forma Pagamento:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="file" id="arquivos" name="arquivos[]" multiple placeholder="Anexos:"/>
                            <label for="arquivos">Anexos:</label>
                        </div>
                    </div>
                </div>
                <div id="editar_arquivos" style='display:none'>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-secondary waves-effect waves-light">Salvar</button>
            </div>
        </form>
    </div>
</div>
<script>
function delete_arq_anexo(arquivo_id){
    if(confirm('Tem certeza que deseja excluir o arquivo?')){
        $.getJSON(
            '{{ route("empresa.projetos.anexos.arquivos.excluir") }}',
            {
                arquivo_id : arquivo_id
            },
            function(json){
                if(json.controle == 'true'){
                    document.getElementById(json.linha).remove();
                }
                else{
                    alert('Ocorreu algum problema e o arquivo não pode ser excluído!');
                }
            }
        );
    }
}
</script>

<!-- Modal Editar Anexo -->
<script>
function modal_visualizar_anexo(anexo_id){
    document.getElementById('editar_arquivos').style.display = 'none';
    $.getJSON(
        "{{ route('empresa.projetos.anexos.buscar') }}",
        {
            anexo_id : anexo_id
        },
        function(json){
            document.getElementById('visualizar_nm_anexo').innerHTML = json.nm_anexo;
            document.getElementById('visualizar_ds_anexo').innerHTML = json.ds_anexo;
            document.getElementById('visualizar_vl_anexo').innerHTML = json.vl_anexo;
            document.getElementById('visualizar_ds_forma_pagamento').innerHTML = json.ds_forma_pagamento;
            if(json.arquivos == 'true'){
                document.getElementById('visualizar_arquivos').innerHTML = json.html_view;
                document.getElementById('visualizar_arquivos').style.display = 'block';
            }

            const myModal = new bootstrap.Modal(document.getElementById('modal_visualizar_anexo'));
            myModal.show();
        }
    );
}
</script>
<div class="modal fade" id="modal_visualizar_anexo" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Visualizar Anexo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group mt-3">
                        <label for="nm_anexo">Nome:</label><br>
                        <b id='visualizar_nm_anexo'></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group mt-3">
                        <label for="ds_anexo">Descrição</label><br>
                        <b id='visualizar_ds_anexo'></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group mt-3">
                        <label for="vl_anexo">Valor:</label><br>
                        <b id='visualizar_vl_anexo'></b>
                    </div>
                    <div class="col-md-6 form-group mt-3">
                        <label for="ds_forma_pagamento">Forma Pagamento:</label><br>
                        <b id='visualizar_ds_forma_pagamento'></b>
                    </div>
                </div>
                <div id="visualizar_arquivos" style='display:none'>

                </div>
            </div>
        </form>
    </div>
</div>

<!-- Fim áreas dos modais -->

<script>
function excluir_anexo(anexo_id){
    if(confirm('Tem certeza que deseja excluir o anexo?')){
        window.location.href = "{{ route('empresa.projetos.anexos.delete') }}/" + anexo_id;
    }
}

function confirmar_pagamento_boleto(boleto_id){
    if(confirm('Tem certeza que de registrar esse pagamento?')){
        window.location.href = "{{ route('empresa.projetos.financeiro.set_pagamento') }}/" + boleto_id;
    }
}

function confirmar_pagamento_boleto_anexo(boleto_id){
    if(confirm('Tem certeza que de registrar esse pagamento?')){
        window.location.href = "{{ route('empresa.projetos.anexos.financeiro.set_pagamento') }}/" + boleto_id;
    }
}

function cancelar_pagamento_boleto(boleto_id){
    if(confirm('Tem certeza que de registrar esse pagamento?')){
        window.location.href = "{{ route('empresa.projetos.financeiro.cancela_pagamento') }}/" + boleto_id;
    }
}

function cancelar_pagamento_boleto_anexo(boleto_id){
    if(confirm('Tem certeza que de registrar esse pagamento?')){
        window.location.href = "{{ route('empresa.projetos.anexos.financeiro.cancela_pagamento') }}/" + boleto_id;
    }
}

function salva_etapa(e, etapa_id){
    if(e.checked){
        st_etapa = 'Concluída';
    }
    else{
        st_etapa = 'Aberta';
    }
    $.getJSON(
        '{{ route("empresa.projetos.etapas.set_etapa") }}',
        {
            st_etapa : st_etapa,
            etapa_id : etapa_id
        },
        function(json){
            barra = document.getElementById('porcentagem_etapa_' + json.produto_id);
            barra.style.width = json.porcentagem_concluida + '%';
            barra.setAttribute('aria-valuenow', json.porcentagem_concluida);
            barra.innerHTML = json.porcentagem_concluida + '%';
        }

    );
}
</script>
@endsection
