@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Projetos</h4>
    {{-- <a href="{{ route('empresa.orcamentos.adicionar') }}" class="btn btn-secondary">Adicionar</a> --}}
</div>
@if($mensagem = Session::get('mensagem'))
    <div class="alert alert-success alert-dismissible mt-3" role="alert">
        {{ $mensagem }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<hr>
<div class="card card-border-shadow-primary mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="tabela-index" id="table-index">
                <thead>
                    <tr>
                        <th>Contratação</th>
                        <th>Entrega</th>
                        <th>Cliente</th>
                        <th>Título</th>
                        <th>Valor Total</th>
                        <th>Forma Pagamento</th>
                        <th>Qt. Itens</th>
                        <th>Situação</th>
                        <th></th>
                    </tr>
                </thead>
                @foreach($projetos as $projeto)
                    <tr>
                        <td><span style='display:none'>{{ strtotime($projeto->dt_contratacao) }}</span>{{ dataDbForm($projeto->dt_contratacao) }}</td>
                        <td><span style='display:none'>{{ strtotime($projeto->getProximaEntrega()) }}</span>{{ dataDbForm($projeto->getProximaEntrega()) }}</td>
                        <td>{{ $projeto->cliente->nm_cliente }}</td>
                        <td>{{ $projeto->nm_projeto }}</td>
                        <td>R$ {{ valorDbForm($projeto->vl_projeto) }}</td>
                        <td>{{ $projeto->ds_forma_pagamento }}</td>
                        <td>{{ $projeto->proj_produtos()->count() }}</td>
                        <td>{{ $projeto->st_projeto }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu" data-popper-placement="bottom-end">
                                    <a class="dropdown-item waves-effect" href="{{ route('empresa.projetos.acessar', $projeto->id) }}"><i class="mdi mdi-application-export me-1"></i> Acessar</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
<script>
window.addEventListener('load',()=>{
  $('#table-index').DataTable({
    order: [[0, 'asc']],
    "language": {
			"sEmptyTable": "Nenhum registro encontrado",
      "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
      "sInfoFiltered": "(Filtrados de _MAX_ registros)",
      "sInfoPostFix": "",
      "sInfoThousands": ".",
      "sLengthMenu": "_MENU_ resultados por página",
      "sLoadingRecords": "Carregando...",
      "sProcessing": "Processando...",
      "sZeroRecords": "Nenhum registro encontrado",
      "sSearch": "Pesquisar",
      "oPaginate": {
        "sNext": "Próximo",
        "sPrevious": "Anterior",
        "sFirst": "Primeiro",
        "sLast": "Último"
      },
      "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
      }
    }
  });
})

</script>
@endsection
