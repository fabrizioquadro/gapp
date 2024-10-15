@extends('layout.login')

@section('conteudo')
<h4 class="mb-2">Bem Vindo à <img style='margin-left: 10px' src="{{ asset('/public/img/logo.png') }}" height="50px"></h4>
<p class="mb-4">Área Empresa - Recuperar Senha</p>
@if($mensagem = Session::get('mensagem_erro'))
    <div class="alert alert-danger" role="alert">
        {{ $mensagem }}
    </div>
@endif
<form id="formAuthentication" class="mb-3" action="{{ route('empresa.gerar_nova_senha') }}" method="POST">
    @csrf
    <div class="form-floating form-floating-outline mb-3">
        <input required type="email" class="form-control" name="email" placeholder="Email:"/>
        <label for="email">Email:</label>
    </div>
    <button class="btn btn-secondary d-grid w-100">Gerar Nova Senha</button>
</form>
@endsection
