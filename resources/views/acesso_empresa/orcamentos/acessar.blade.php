@extends('layout.empresa')

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
        $situacao = "Fechado";
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
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalEditarOrcamento" class="btn btn-sm btn-text-primary waves-effect waves-light">Editar</button>
            </div>
            <div class="row">
                <div class="col-md-6 form-group mt-3">
                    <label for="">Título:</label><br>
                    <b>{{ $orcamento->titulo }}</b>
                </div>
                <div class="col-md-6 form-group mt-3">
                    <label for="">Cliente:</label><br>
                    <b>{{ $orcamento->cliente->nm_cliente }}</b>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-group mt-3">
                    <label for="">Data Orçamento:</label><br>
                    <b>{{ dataDbForm($dt_orcamento) }}</b>
                </div>
                <div class="col-md-3 form-group mt-3">
                    <label for="">Validade:</label><br>
                    <b>{{ $orcamento->validade }} dias</b>
                </div>
                <div class="col-md-3 form-group mt-3">
                    <label for="">Vencimento:</label><br>
                    <b>{{ dataDbForm($dt_validade) }}</b>
                </div>
                <div class="col-md-3 form-group mt-3">
                    <label for="">Situação:</label><br>
                    <b>{{ $situacao }}</b>
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
                            <button type="button" class="btn btn-xs rounded-pill btn-outline-danger waves-effect" onclick="delete_arq_orcamento({{ $arquivo->id }})">Excluir</button>
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
                    <button type="button" onclick='editar_item({{ $produto->id }})' class="btn btn-sm btn-text-warning waves-effect waves-light">Editar</button>
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
                        <label for="">Situação Produto:</label><br>
                        <b>{{ $produto->st_produto }}</b>
                    </div>
                </div>
                @if($produto->ds_produto)
                <div class="row mt-3">
                    <div class="col-md-12 form-group">
                        <label for="">Descrição do Item:</label><br>
                        <b>R$ {{ $produto->ds_produto }}</b>
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
                                <button type="button" class="btn btn-xs rounded-pill btn-outline-danger waves-effect" onclick="delete_arq_produto({{ $arquivo->id }})">Excluir</button>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @endif
                <h6 class="card-title mt-5">Etapas</h6>
                @php
                $etapas = "";
                foreach($produto->etapas as $etapa){
                    $etapas .= ', '.$etapa->nm_etapa;
                }
                $etapas = substr($etapas,2);
                @endphp
                <p>
                    {{ $etapas }}
                </p>
            </div>
        </div>
    @endforeach
    <div class="card card-border-shadow-success mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h6 class="card-title">Formas de Pagamento</h6>
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalEditarFormaPagamento" class="btn btn-sm btn-text-success waves-effect waves-light">Editar</button>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <b>Pagamento Ávista:</b><br>
                        Porcentagem de desconto para pagamento àvista nas formas de pix e boleto ou cartão de crédito.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="avista">Desconto Ávista:</label><br>
                    <b>{{ $orcamento->desconto_avista }} %</b>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-md-12">
                    <p>
                        <b>Parcelamento Cartão de Crédito:</b><br>
                        Número de vezes que o cliente poderá parcelar no cartão de crédito.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="cartao">Parcelamento Cartão Crédito:</label><br>
                    <b>{{ $orcamento->parcelamento_cartao }}</b>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-md-12">
                    <p>
                        <b>Entrada + Sado Devedor:</b><br>
                        Porcentagem de entrada juntamente com a data do vencimento e a quantidade de vezes que o saldo devedor poderá ser dividido, estes pagamentos serão gerados através de boleto ou pix.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="parcelamento_entrada">Porcentagem Entrada:</label><br>
                    <b>{{ $orcamento->parcelamento_entrada }} %</b>
                </div>
                <div class="col-md-4 form-group">
                    <label for="vencimento_entrada">Vencimento Entrada:</label><br>
                    <b>{{ $orcamento->vencimento_entrada != null ? dataDbForm($orcamento->vencimento_entrada) : '' }}</b>
                </div>
                <div class="col-md-4 form-group">
                    <label for="parcelamento_vezes">Número de vezes Saldo Devedor:</label><br>
                    <b>{{ $orcamento->parcelamento_vezes }}</b>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-md-12">
                    <p>
                        <b>Entrada + Entrega:</b><br>
                        Porcentagem do pagamento que é feito de entrata, o restante vai ser ajustado para a data de entrega.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="parcelamento_entrada">Porcentagem Entrada:</label><br>
                    <b>{{ $orcamento->entrega_entrada }} %</b>
                </div>
                <div class="col-md-6 form-group">
                    <label for="vencimento_entrada">Vencimento Entrada:</label><br>
                    <b>{{ $orcamento->entrega_vencimento != null ? dataDbForm($orcamento->entrega_vencimento) : '' }}</b>
                </div>
            </div>
        </div>
    </div>

<!-- Ínicio áreas dos modais -->

<!-- Modal -->
<div class="modal fade" id="modalEditarOrcamento" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('empresa.orcamentos.update') }}" class="modal-content" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="orcamento_id" value="{{ $orcamento->id }}">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Editar Informaçẽs Básicas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="editar_titulo" name='titulo' value="{{ $orcamento->titulo }}" class="form-control" placeholder="Título:">
                            <label for="editar_titulo">Título:</label>
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input type="number" id="editar_validade" name='validade' value="{{ $orcamento->validade }}" class="form-control" placeholder="Validade:">
                            <label for="editar_validade">Validade:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="editar_descricao" name='descricao' placeholder="Descrição do orçamento...">{{ $orcamento->descricao }}</textarea>
                            <label for="editar_descricao">Descrição:</label>
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
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-secondary">Salvar</button>
            </div>
      </form>
    </div>
</div>

<div class="modal fade" id="modal_editar_item" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('empresa.orcamentos.produto.update') }}" class="modal-content" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="produto_id" id="editar_produto_id">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Editar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="editar_nm_produto" name='nm_produto' class="form-control" placeholder="Nome:">
                            <label for="editar_nm_produto">Nome:</label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-floating form-floating-outline">
                            <select required id="editar_st_produto" name='st_produto' class="select2 form-select">
                                <option value="">Situação</option>
                                <option value="Aberto">Aberto</option>
                                <option value="Cancelado">Cancelado</option>
                                <option value="Contratado">Contratado</option>
                            </select>
                            <label for="st_produto">Siuação:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input type="number" id="editar_dias_entrega" name='dias_entrega' class="form-control" placeholder="Entrega (dias):">
                            <label for="editar_dias_entrega">Entrega (dias):</label>
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input required class="form-control" type="text" id="editar_vl_produto" name="vl_produto" placeholder="Valor:" onkeypress="return(MascaraMoeda(this,'.',',',event))"/>
                            <label for="editar_vl_produto">Valor:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="editar_ds_produto" name='ds_produto' placeholder="Descrição do produto/serviço..."></textarea>
                            <label for="editar_ds_produto">Descrição:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-floating form-floating-outline">
                            <input id="editar_produto_etapas" class="form-control h-auto" name="etapas" value="" />
                            <label for="editar_produto_etapas">Etapas</label>
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
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-secondary">Salvar</button>
            </div>
      </form>
    </div>
</div>

<div class="modal fade" id="modalEditarFormaPagamento" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('empresa.orcamentos.forma_pagamento.update') }}" class="modal-content" method="post">
            @csrf
            <input type="hidden" name="orcamento_id" value="{{ $orcamento->id }}">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Editar Formas de Pagamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <b>Pagamento Ávista:</b><br>
                            Informe a porcentagem de desconto para pagamento àvista nas formas de pix e boleto ou cartão de crédito.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input min="0" class="form-control" type="number" id="avista" name="desconto_avista" placeholder="Desconto Àvista(%):" value="{{ $orcamento->desconto_avista }}"/>
                            <label for="avista">Desconto Ávista(%):</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <p>
                            <b>Parcelamento Cartão de Crédito:</b><br>
                            Informe o número de vezes que o cliente poderá parcelar no cartão de crédito.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="number" id="cartao" name="parcelamento_cartao" placeholder="Parcelamento Cartão Crédito:" value="{{ $orcamento->parcelamento_cartao }}"/>
                            <label for="cartao">Parcelamento Cartão Crédito:</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <p>
                            <b>Entrada + Sado Devedor:</b><br>
                            Informe a porcentagem de entrada juntamente com a data do vencimento e a quantidade de vezes que o saldo devedor poderá ser dividido, estes pagamentos serão gerados através de boleto ou pix.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="number" id="parcelamento_entrada" name="parcelamento_entrada" placeholder="Porcentagem Entrada(%):" value="{{ $orcamento->parcelamento_entrada }}"/>
                            <label for="parcelamento_entrada">Porcentagem Entrada(%):</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="date" id="vencimento_entrada" name="vencimento_entrada" placeholder="Vencimento Entrada:" value="{{ $orcamento->vencimento_entrada }}"/>
                            <label for="vencimento_entrada">Vencimento Entrada:</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="number" id="parcelamento_vezes" name="parcelamento_vezes" placeholder="Número de vezes Saldo Devedor:" value="{{ $orcamento->parcelamento_vezes }}"/>
                            <label for="parcelamento_vezes">Número de vezes Saldo Devedor:</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <b>Entrada + Entrega:</b><br>
                            Informe a porcentagem de entrada juntamente com a data do vencimento, o restante vai ter o vencimento para a data de entrega do produto/serviço.<br>
                            Forma de pagamento PIX.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="number" id="entrega_entrada" name="entrega_entrada" placeholder="Porcentagem Entrada(%):"  value="{{ $orcamento->entrega_entrada }}"/>
                            <label for="entrega_entrada">Porcentagem Entrada(%):</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="date" id="entrega_vencimento" name="entrega_vencimento" placeholder="Vencimento Entrada:"  value="{{ $orcamento->entrega_vencimento }}"/>
                            <label for="entrega_vencimento">Vencimento Entrada:</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-secondary">Salvar</button>
            </div>
      </form>
    </div>
</div>

<!-- Fim áreas dos modais -->

<script>
function delete_arq_orcamento(arquivo_id){
    if(confirm('Tem certeza que deseja excluir o arquivo?')){
        window.location.href = "{{ route('empresa.orcamentos.arquivos.delete') }}/" + arquivo_id;
    }
}

function editar_item(item_id){
    $.getJSON(
        "{{ route('empresa.orcamentos.produto.buscar') }}",
        {
            produto_id : item_id
        },
        function(json){
            document.getElementById('editar_produto_id').value = json.produto_id;
            document.getElementById('editar_nm_produto').value = json.nm_produto;
            document.getElementById('editar_vl_produto').value = json.vl_produto;
            document.getElementById('editar_dias_entrega').value = json.dias_entrega;
            document.getElementById('editar_ds_produto').value = json.ds_produto;
            document.getElementById('editar_st_produto').value = json.st_produto;
            document.getElementById('editar_produto_etapas').value = json.etapas;

            const myModal = new bootstrap.Modal(document.getElementById('modal_editar_item'));
            myModal.show();
        }
    );
}

function delete_arq_produto(arquivo_id){
    if(confirm('Tem certeza que deseja excluir o arquivo?')){
        window.location.href = "{{ route('empresa.orcamentos.produto.arquivos.delete') }}/" + arquivo_id;
    }
}

window.addEventListener('load',()=>{
    tagifyBasicEl = document.querySelector("#editar_produto_etapas");
    TagifyBasic = new Tagify(tagifyBasicEl);
});
</script>
@endsection
