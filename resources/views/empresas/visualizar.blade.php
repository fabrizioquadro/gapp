@extends('layout.admin')

@section('conteudo')
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Visualizar Empresa</h4>
        </div>
        <hr>
        @if($empresa->imagem)
            <div class="row mt-1 gy-4">
                <div class="col-md-3">
                    <img src='{{ asset("/public/empresas/imagem/$empresa->imagem") }}' class='img-fluid' alt="">
                </div>
            </div>
        @endif
        <div class="row mt-1 gy-4">
            <div class="col-md-6 form-group">
                <label for="nome">Nome:</label><br>
                <b>{{ $empresa->nm_empresa }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="email">E-mail:</label><br>
                <b>{{ $empresa->ds_email }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="email">Pessoa:</label><br>
                <b>{{ $empresa->tp_empresa }}</b>
            </div>
        </div>
        <div class="row mt-1 gy-4">
            <div class="col-md-4 form-group">
                <label for="email">Cnpj:</label><br>
                <b>{{ $empresa->nr_cnpj }}</b>
            </div>
            <div class="col-md-4 form-group">
                <label for="email">Telefone:</label><br>
                <b>{{ $empresa->nr_tel }}</b>
            </div>
            <div class="col-md-4 form-group">
                <label for="email">Celular:</label><br>
                <b>{{ $empresa->nr_cel }}</b>
            </div>
        </div>
        <div class="row mt-1 gy-4">
            <div class="col-md-6 form-group">
                <label for="email">Endereço:</label><br>
                <b>{{ $empresa->ds_endereco }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="email">Número:</label><br>
                <b>{{ $empresa->nr_endereco }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="email">Complemento:</label><br>
                <b>{{ $empresa->ds_complemento }}</b>
            </div>
        </div>
        <div class="row mt-1 gy-4">
            <div class="col-md-3 form-group">
                <label for="email">Bairro:</label><br>
                <b>{{ $empresa->ds_bairro }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="email">Cidade:</label><br>
                <b>{{ $empresa->nm_cidade }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="email">UF:</label><br>
                <b>{{ $empresa->ds_uf }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="email">Cep:</label><br>
                <b>{{ $empresa->nr_cep }}</b>
            </div>
        </div>
        <div class="row mt-1 gy-4">
            <div class="col-md-6 form-group">
                <label for="email">Situação:</label><br>
                <b>{{ $empresa->st_empresa }}</b>
            </div>
        </div>
        <div class="row mt-1 gy-4">
            <div class="col-md-12 form-group">
                <label for="">Descrição da Empresa</label><br>
                {!! $empresa->ds_empresa !!}
            </div>
        </div>
    </div>
</div>
@endsection
