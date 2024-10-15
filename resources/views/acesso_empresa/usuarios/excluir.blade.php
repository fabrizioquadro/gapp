@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Excluir Usuário</h4>
</div>
<hr>
<div class="card card-border-shadow-danger mb-4">
    <div class="card-body">
        <form action="{{ route('empresa.usuarios.delete') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <p>Tem certeza que deseja excluir o usuário(a) {{ $user->nm_user }}?</p>
            <div class="mt-4">
                <button type="submit" class="btn btn-danger me-2">Excluir</button>
            </div>
        </form>
    </div>
<!-- /Account -->
</div>
@endsection
