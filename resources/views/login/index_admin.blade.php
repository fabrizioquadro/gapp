@extends('layout.login')

@section('conteudo')
<h4 class="mb-2">Bem Vindo à <img style='margin-left: 10px' src="{{ asset('/public/img/logo.png') }}" height="50px"></h4>
<p class="mb-4">Área Admiistrativa - Login</p>
@if($mensagem = Session::get('mensagem_erro'))
    <div class="alert alert-danger" role="alert">
        {{ $mensagem }}
    </div>
@endif
@if($mensagem = Session::get('mensagem_sucesso'))
    <div class="alert alert-success" role="alert">
        {{ $mensagem }}
    </div>
@endif
<form id="formAuthentication" class="mb-3" action="{{ route('admin.login') }}" method="POST">
    @csrf
    <div class="form-floating form-floating-outline mb-3">
        <input required type="email" class="form-control" name="email" placeholder="Email:"/>
        <label for="email">Email:</label>
    </div>
    <div class="mb-3">
        <div class="form-password-toggle">
            <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                    <input required type="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="Senha:" />
                    <label for="password">Senha:</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
            </div>
        </div>
    </div>
    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('admin.recuperar_senha') }}" class="float-end mb-1">
            <span>Esqueceu Senha?</span>
        </a>
    </div>
    <button class="btn btn-secondary d-grid w-100">Entrar</button>
</form>
@endsection
