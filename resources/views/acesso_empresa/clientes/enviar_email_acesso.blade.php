@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Enviar Email de Acesso - {{ $cliente->nm_cliente }}</h4>
</div>
<hr>
<div class="card card-border-shadow-primary">
    <div class="card-body">
        <form action="{{ route('empresa.clientes.enviar_email_acesso.send') }}" method="POST">
            @csrf
            <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        Será gerado uma nova senha e enviado para o cliente com os dados de acesso da sua conta na plataforma.
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-secondary me-2">Enviar Email</button>
            </div>
        </form>
    </div>
<!-- /Account -->
</div>
@endsection
