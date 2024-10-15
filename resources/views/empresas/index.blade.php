@extends('layout.admin')

@section('conteudo')
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Empresas</h4>
            <a href="{{ route('admin.empresas.adicionar') }}" class="btn btn-secondary">Adicionar</a>
        </div>
        @if($mensagem = Session::get('mensagem'))
            <div class="alert alert-success alert-dismissible mt-3" role="alert">
                {{ $mensagem }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <hr>
        <div class="table-responsive">
            <table class="tabela-index" id="table-index">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nome</th>
                        <th>Pessoa</th>
                        <th>Cnpj</th>
                        <th>Tel</th>
                        <th>Cel</th>
                        <th>Email</th>
                        <th>Situação</th>
                        <th></th>
                    </tr>
                </thead>
                @foreach($empresas as $empresa)
                    @php
                    if($empresa->imagem){
                        $avatar = "/public/empresas/imagem/$empresa->imagem";
                    }
                    else{
                        $avatar = '/public/template/img/illustrations/trophy.png';
                    }
                    @endphp
                    <tr>
                        <td><img src="{{ $avatar }}" style='height:40px; border-radius: 20px' alt=""> </td>
                        <td>{{ $empresa->nm_empresa }}</td>
                        <td>{{ $empresa->tp_empresa }}</td>
                        <td>{{ $empresa->nr_cnpj }}</td>
                        <td>{{ $empresa->nr_tel }}</td>
                        <td>{{ $empresa->nr_cel }}</td>
                        <td>{{ $empresa->ds_email }}</td>
                        <td>{{ $empresa->st_empresa }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu" data-popper-placement="bottom-end">
                                    <a class="dropdown-item waves-effect" href="{{ route('admin.empresas.editar', $empresa->id) }}"><i class="mdi mdi-pencil-outline me-1"></i> Editar</a>
                                    <a class="dropdown-item waves-effect" href="{{ route('admin.empresas.excluir', $empresa->id) }}"><i class="mdi mdi-trash-can-outline me-1"></i> Excluir</a>
                                    <a class="dropdown-item waves-effect" href="{{ route('admin.empresas.visualizar', $empresa->id) }}"><i class="mdi mdi-eye me-1"></i> Visualizar</a>
                                    <a class="dropdown-item waves-effect" href="{{ route('admin.empresas.alterar_senha', $empresa->id) }}"><i class="mdi mdi-lock-reset me-1"></i> Alterar Senha</a>
                                    <a class="dropdown-item waves-effect" href="{{ route('admin.empresas.mensagens', $empresa->id) }}"><i class="mdi mdi-message-outline me-1"></i> Mensagens</a>
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
    order: [[1, 'asc']],
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
