@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Adicionar Cliente</h4>
</div>
<hr>
<div class="card card-border-shadow-primary mb-4">
    <div class="card-body">
        <form action="{{ route('empresa.clientes.insert') }}" method="post">
            @csrf
            <div class="row mt-1 gy-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="nome" name="nm_cliente" placeholder="Nome:"/>
                        <label for="nome">Nome:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="email" id="email" name="ds_email" placeholder="john.doe@example.com" />
                        <label for="email">E-mail:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <select id="tp_cliente" name='tp_cliente' class="select2 form-select">
                            <option value=""></option>
                            <option value="Pessoa Física">Pessoa Física</option>
                            <option value="Pessoa Jurídica">Pessoa Jurídica</option>
                        </select>
                        <label for="tp_cliente">Pessoa:</label>
                    </div>
                </div>
            </div>
            <div class="row mt-1 gy-4">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="nr_cpf" name="nr_cpf" placeholder="CPF:"/>
                        <label for="nr_cpf">CPF:</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="tel" name="nr_tel" placeholder="Telefone:" maxlength="15" onkeypress="mascara( this, mtel )" />
                        <label for="tel">Telefone:</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="cel" name="nr_cel" placeholder="Celular:" maxlength="15" onkeypress="mascara( this, mtel )" />
                        <label for="cel">Celular:</label>
                    </div>
                </div>
            </div>
            <div class="row mt-1 gy-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="endereco" name="ds_endereco" placeholder="Endereço:"/>
                        <label for="endereco">Endereço:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="numero" name="nr_endereco" placeholder="Número:" />
                        <label for="numero">Número:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="complemento" name="ds_complemento" placeholder="Complemento:" />
                        <label for="complemento">Complemento:</label>
                    </div>
                </div>
            </div>
            <div class="row mt-1 gy-4">
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="bairro" name="ds_bairro" placeholder="Bairro:"/>
                        <label for="bairro">Bairro:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="cidade" name="nm_cidade" placeholder="Cidade:" />
                        <label for="cidade">Cidade:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="uf" name="ds_uf" placeholder="UF:" />
                        <label for="uf">UF:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="cep" name="nr_cep" placeholder="CEP:"  maxlength="9" onkeypress="formatar('#####-###', this)" />
                        <label for="cep">CEP:</label>
                    </div>
                </div>
            </div>
            <div class="row mt-1 gy-4">
                <div class="col-md-6">
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="enviar_senha_cliente" checked value="sim">
                        <label class="form-check-label" for="defaultCheck1"> Enviar senha com dados de acesso? </label>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-secondary me-2">Salvar</button>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('tp_cliente').addEventListener('change', (e)=>{
    if(e.target.value == "Pessoa Física"){
        document.getElementById('nr_cpf').setAttribute('maxlength', '14');
        document.getElementById('nr_cpf').setAttribute('onkeypress', "formatar('###.###.###-##', this)");
    }
    else if(e.target.value == "Pessoa Jurídica"){
        document.getElementById('nr_cpf').setAttribute('maxlength', '18');
        document.getElementById('nr_cpf').setAttribute('onkeypress', "formatar('##.###.###/####-##', this)");
    }
    else{
        document.getElementById('nr_cpf').removeAttribute('maxlength');
        document.getElementById('nr_cpf').removeAttribute('onkeypress');
    }
})
</script>
@endsection
