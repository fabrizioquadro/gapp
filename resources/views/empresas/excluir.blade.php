@extends('layout.admin')

@section('conteudo')
<div class="card mb-4">
    <h4 class="card-header">Excluir Empresa</h4>
    <div class="card-body">
        <form action="{{ route('admin.empresas.delete') }}" method="POST">
            @csrf
            <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
            <p>Tem certeza que deseja excluir a empresa {{ $empresa->nm_empresa }}?</p>
            <div class="mt-4">
                <button type="submit" class="btn btn-danger me-2">Excluir</button>
            </div>
        </form>
    </div>
<!-- /Account -->
</div>
@endsection
