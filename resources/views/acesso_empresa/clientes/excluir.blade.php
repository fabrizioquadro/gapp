@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Excluir Cliente</h4>
</div>
<hr>
<div class="card card-border-shadow-danger">
    <div class="card-body">
        <form action="{{ route('empresa.clientes.delete') }}" method="POST">
            @csrf
            <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        Tem certeza que deseja excluir o cliente {{ $cliente->nm_cliente }}?
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-danger me-2">Excluir</button>
            </div>
        </form>
    </div>
<!-- /Account -->
</div>
@endsection
