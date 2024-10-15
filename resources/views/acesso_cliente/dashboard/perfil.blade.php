@extends('layout.cliente')

@section('conteudo')
    <div class="d-flex justify-content-between">
        <h4 class="card-title">Perfil</h4>
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
            <form action="{{ route('cliente.perfil.update') }}" method="post">
                @csrf
                <div class="row mt-1 gy-4">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input required class="form-control" type="text" id="nome" name="nm_cliente" placeholder="Nome:" value="{{ $cliente->nm_cliente }}"/>
                            <label for="nome">Nome:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline">
                            <input required class="form-control" type="email" id="email" name="ds_email" placeholder="john.doe@example.com" value="{{ $cliente->ds_email }}" />
                            <label for="email">E-mail:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline">
                            <select id="tp_cliente" name='tp_cliente' class="select2 form-select">
                                <option value=""></option>
                                <option @if($cliente->tp_cliente == "Pessoa Física") selected @endif value="Pessoa Física">Pessoa Física</option>
                                <option @if($cliente->tp_cliente == "Pessoa Jurídica") selected @endif value="Pessoa Jurídica">Pessoa Jurídica</option>
                            </select>
                            <label for="tp_cliente">Pessoa:</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-1 gy-4">
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="cnpj" name="nr_cpf" placeholder="CPF:" maxlength="14" onkeypress="formatar('###.###.###-##', this)" value="{{ $cliente->nr_cpf }}"/>
                            <label for="cnpj">CPF:</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="tel" name="nr_tel" placeholder="Telefone:" maxlength="15" onkeypress="mascara( this, mtel )" value="{{ $cliente->nr_tel }}" />
                            <label for="tel">Telefone:</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="cel" name="nr_cel" placeholder="Celular:" maxlength="15" onkeypress="mascara( this, mtel )" value="{{ $cliente->nr_cel }}" />
                            <label for="cel">Celular:</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-1 gy-4">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="endereco" name="ds_endereco" placeholder="Endereço:" value="{{ $cliente->ds_endereco }}"/>
                            <label for="endereco">Endereço:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="numero" name="nr_endereco" placeholder="Número:" value="{{ $cliente->nr_endereco }}" />
                            <label for="numero">Número:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="complemento" name="ds_complemento" placeholder="Complemento:" value="{{ $cliente->ds_complemento }}" />
                            <label for="complemento">Complemento:</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-1 gy-4">
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="bairro" name="ds_bairro" placeholder="Bairro:" value="{{ $cliente->ds_bairro }}"/>
                            <label for="bairro">Bairro:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="cidade" name="nm_cidade" placeholder="Cidade:" value="{{ $cliente->nm_cidade }}" />
                            <label for="cidade">Cidade:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="uf" name="ds_uf" placeholder="UF:" value="{{ $cliente->ds_uf }}" />
                            <label for="uf">UF:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="cep" name="nr_cep" placeholder="CEP:"  maxlength="9" onkeypress="formatar('#####-###', this)" value="{{ $cliente->nr_cep }}" />
                            <label for="cep">CEP:</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-secondary me-2">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
