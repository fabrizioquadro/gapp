@extends('layout.cliente')

@section('conteudo')
<div class="d-flex justify-content-between">
<h4 class="card-title">Projetos</h4>
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
                        <th>Título</th>
                        <th>Valor Total</th>
                        <th>Forma Pagamento</th>
                        <th>Qt. Itens</th>
                    </tr>
                </thead>
                @foreach($projetos as $projeto)
                    @php
                    $var = explode(' ', $projeto->dt_contratacao);
                    $dt_contratacao = $var[0];
                    @endphp
                    <tr style="cursor: pointer" onclick="acessar_projeto({{ $projeto->id }})">
                        <td><span style='display:none'>{{ strtotime($projeto->dt_contratacao) }}</span>{{ dataDbForm($projeto->dt_contratacao) }}</td>
                        <td><span style='display:none'>{{ strtotime($projeto->getProximaEntrega()) }}</span>{{ dataDbForm($projeto->getProximaEntrega()) }}</td>
                        <td>{{ $projeto->nm_projeto }}</td>
                        <td>R$ {{ valorDbForm($projeto->vl_projeto) }}</td>
                        <td>{{ $projeto->ds_forma_pagamento }}</td>
                        <td>{{ $projeto->proj_produtos()->count() }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
<script>
window.addEventListener('load',()=>{
    $('#table-index').DataTable({
        order: [[0, 'desc']],
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

function acessar_projeto(projeto_id){
    window.location.href = "{{ route('cliente.projetos.acessar') }}/" + projeto_id;
}

</script>
@endsection
