@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Clientes</h4>
    <a href="{{ route('empresa.clientes.adicionar') }}" class="btn btn-secondary">Adicionar</a>
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
                        <th>Nome</th>
                        <th>Pessoa</th>
                        <th>Cpf</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Celular</th>
                        <th></th>
                    </tr>
                </thead>
                @foreach($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->nm_cliente }}</td>
                        <td>{{ $cliente->tp_cliente }}</td>
                        <td>{{ $cliente->nr_cpf }}</td>
                        <td>{{ $cliente->ds_email }}</td>
                        <td>{{ $cliente->nr_tel }}</td>
                        <td>{{ $cliente->nr_cel }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu" data-popper-placement="bottom-end">
                                    <a class="dropdown-item waves-effect" href="{{ route('empresa.clientes.editar', $cliente->id) }}"><i class="mdi mdi-pencil-outline me-1"></i> Editar</a>
                                    <a class="dropdown-item waves-effect" href="{{ route('empresa.clientes.excluir', $cliente->id) }}"><i class="mdi mdi-trash-can-outline me-1"></i> Excluir</a>
                                    <a class="dropdown-item waves-effect" href="{{ route('empresa.clientes.alterar_senha', $cliente->id) }}"><i class="mdi mdi-lock-reset me-1"></i> Alterar Senha</a>
                                    <a class="dropdown-item waves-effect" href="{{ route('empresa.clientes.visualizar', $cliente->id) }}"><i class="mdi mdi-eye-outline me-1"></i> Visualizar</a>
                                    <a class="dropdown-item waves-effect" href="{{ route('empresa.clientes.enviar_email_acesso', $cliente->id) }}"><i class="mdi mdi-email-arrow-right-outline me-1"></i> Enviar Email Acesso </a>
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
