@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Visualizar Modelo: {{ $modelo->nm_modelo }}</h4>
</div>
<hr>
<div class="card card-border-shadow-primary mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-primary">Etapas Registradas</li>
                    @foreach($modelo->etapas as $etapa)
                        <li class="list-group-item">{{ $etapa->nm_etapa }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
