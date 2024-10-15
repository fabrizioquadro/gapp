@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Visualizar Cliente</h4>
</div>
<hr>
<div class="card card-border-shadow-primary mb-4">
    <div class="card-body">
        <div class="row mt-1 gy-4">
            <div class="col-md-6 form-group">
                <label for="">Nome:</label><br>
                <b>{{ $cliente->nm_cliente }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="">E-mail:</label><br>
                <b>{{ $cliente->ds_email }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="">Pessoa:</label><br>
                <b>{{ $cliente->tp_cliente }}</b>
            </div>
        </div>
        <div class="row mt-1 gy-4">
            <div class="col-md-4 form-group">
                <label for="">CPF:</label><br>
                <b>{{ $cliente->nr_cpf }}</b>
            </div>
            <div class="col-md-4 form-group">
                <label for="">Telefone:</label><br>
                <b>{{ $cliente->nr_tel }}</b>
            </div>
            <div class="col-md-4 form-group">
                <label for="">Celular:</label><br>
                <b>{{ $cliente->nr_cel }}</b>
            </div>
        </div>
        <div class="row mt-1 gy-4">
            <div class="col-md-6 form-group">
                <label for="">Endereço:</label><br>
                <b>{{ $cliente->ds_endereco }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="">Número:</label><br>
                <b>{{ $cliente->nr_endereco }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="">Complemento:</label><br>
                <b>{{ $cliente->ds_complemento }}</b>
            </div>
        </div>
        <div class="row mt-1 gy-4">
            <div class="col-md-3 form-group">
                <label for="">Bairro:</label><br>
                <b>{{ $cliente->ds_bairro }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="">Cidade:</label><br>
                <b>{{ $cliente->nm_cidade }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="">UF:</label><br>
                <b>{{ $cliente->ds_uf }}</b>
            </div>
            <div class="col-md-3 form-group">
                <label for="">CEP:</label><br>
                <b>{{ $cliente->nr_cep }}</b>
            </div>
        </div>
    </div>
</div>
@endsection
