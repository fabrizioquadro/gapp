@extends('layout.admin')

@section('conteudo')
<div class="card mb-4">
    <h4 class="card-header">Excluir Plano</h4>
    <div class="card-body">
        <form action="{{ route('admin.planos.delete') }}" method="POST">
            @csrf
            <input type="hidden" name="plano_id" value="{{ $plano->id }}">
            <p>Tem certeza que deseja excluir o plano {{ $plano->nm_plano }}?</p>
            <div class="mt-4">
                <button type="submit" class="btn btn-danger me-2">Excluir</button>
            </div>
        </form>
    </div>
<!-- /Account -->
</div>
@endsection
