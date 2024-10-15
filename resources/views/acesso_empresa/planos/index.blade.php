@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Adquirir Plano</h4>
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
        <div class="card-title">Validade do Acesso: {{ dataDbForm($empresa->dt_validade) }}</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Plano</th>
                        <th>Descrição</th>
                        <th>Validade(Dias)</th>
                        <th>Valor</th>
                        <th></th>
                    </tr>
                </thead>
                @foreach($planos as $plano)
                    <tr>
                        <td>{{ $plano->nm_plano }}</td>
                        <td>{{ $plano->ds_plano }}</td>
                        <td>{{ $plano->dias_validade }}</td>
                        <td>R$ {{ valorDbForm($plano->vl_plano) }}</td>
                        <td>
                            <a href="{{ route('empresa.planos.adquirir', $plano->id) }}" class="btn btn-label-secondary waves-effect">Adquirir</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
