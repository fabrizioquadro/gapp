@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Editar Modelo de Etapas</h4>
</div>
<hr>
<div class="card card-border-shadow-primary mb-4">
    <div class="card-body">
        <form action="{{ route('empresa.modelo_etapa.delete') }}" method="post">
            @csrf
            <input type="hidden" name="modelo_id" value="{{ $modelo->id }}">
            <div class="row">
                <div class="col-md-12">
                    <p>Tem certeza que deseja excluir o modelo {{ $modelo->nm_modelo }}?</p>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-danger me-2">Excluir</button>
            </div>
        </form>
    </div>
</div>
@endsection
