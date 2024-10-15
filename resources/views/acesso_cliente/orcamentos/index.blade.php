@extends('layout.cliente')

@section('conteudo')
<div class="d-flex justify-content-between">
<h4 class="card-title">Orçamentos</h4>
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
                    <th>Data</th>
                    <th>Título</th>
                    <th>Validade</th>
                    <th>Valor Total</th>
                    <th>Situação</th>
                </tr>
            </thead>
            @foreach($orcamentos as $orcamento)
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
                <tr style="cursor: pointer" onclick="acessar_orcamento({{ $orcamento->id }})">
                    <td><span style='display:none'>{{ strtotime($dt_orcamento) }}</span>{{ dataDbForm($dt_orcamento) }}</td>
                    <td>{{ $orcamento->titulo }}</td>
                    <td>{{ dataDbForm($dt_validade) }}</td>
                    <td>R$ {{ valorDbForm($orcamento->get_valor_orcamento()) }}</td>
                    <td>{{ $situacao }}</td>
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

function acessar_orcamento(orcamento_id){
    window.location.href = "{{ route('cliente.orcamentos.acessar') }}/" + orcamento_id;
}

</script>
@endsection
