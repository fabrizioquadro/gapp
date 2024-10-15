@extends('layout.empresa')

@section('conteudo')
@php
if($empresa->imagem){
    $avatar = "/public/empresas/imagem/$empresa->imagem";
}
else{
    $avatar = '/public/template/img/illustrations/trophy.png';
}
@endphp
<div class="d-flex justify-content-between">
    <h4 class="card-title">Perfil</h4>
</div>
<hr>
<div class="card">
    <div class="card-body">
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
        <form action="{{ route('empresa.perfil.set_foto') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-start align-items-sm-center gap-4">
                <img src="{{ asset($avatar) }}" alt="user-avatar" class="img-fluid" id="uploadedAvatar" />
                <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                        <span class="d-none d-sm-block">Enviar Nova Foto</span>
                        <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                        <input onchange="submit()" name="imagem" id="upload" type="file" class="account-file-input" hidden accept="image/png, image/jpeg" />
                    </label>
                    <button type="button" id='btnExcluirFoto' class="btn btn-outline-danger account-image-reset mb-3">
                        <i class="mdi mdi-reload d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Excluir Foto</span>
                    </button>
                    <div class="small">Somente JPG, GIF or PNG.</div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <form action="{{ route('empresa.perfil.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mt-1 gy-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="nome" name="nm_empresa" value="{{ $empresa->nm_empresa }}"/>
                        <label for="nome">Nome:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="email" id="email" name="ds_email" value="{{ $empresa->ds_email }}" />
                        <label for="email">E-mail:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <select id="tp_empresa" name='tp_empresa' class="form-select">
                            <option value=""></option>
                            <option @if($empresa->tp_empresa == "Pessoa Física") selected @endif value="Pessoa Física">Pessoa Física</option>
                            <option @if($empresa->tp_empresa == "Pessoa Jurídica") selected @endif value="Pessoa Jurídica">Pessoa Jurídica</option>
                        </select>
                        <label for="tp_empresa">Pessoa:</label>
                    </div>
                </div>
            </div>
            <div class="row mt-1 gy-4">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="nr_cnpj" name="nr_cnpj" placeholder="CNPJ/CPF:" value="{{ $empresa->nr_cnpj }}"/>
                        <label for="nr_cnpj">CNPJ/CPF:</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="tel" name="nr_tel" placeholder="Telefone:" maxlength="15" onkeypress="mascara( this, mtel )" value="{{ $empresa->nr_tel }}" />
                        <label for="tel">Telefone:</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="cel" name="nr_cel" placeholder="Celular:" maxlength="15" onkeypress="mascara( this, mtel )" value="{{ $empresa->nr_cel }}" />
                        <label for="cel">Celular:</label>
                    </div>
                </div>
            </div>
            <div class="row mt-1 gy-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="endereco" name="ds_endereco" placeholder="Endereço:" value="{{ $empresa->ds_endereco }}"/>
                        <label for="endereco">Endereço:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="numero" name="nr_endereco" placeholder="Número:" value="{{ $empresa->nr_endereco }}" />
                        <label for="numero">Número:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="complemento" name="ds_complemento" placeholder="Complemento:" value="{{ $empresa->ds_complemento }}" />
                        <label for="complemento">Complemento:</label>
                    </div>
                </div>
            </div>
            <div class="row mt-1 gy-4">
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="bairro" name="ds_bairro" placeholder="Bairro:" value="{{ $empresa->ds_bairro }}"/>
                        <label for="bairro">Bairro:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="cidade" name="nm_cidade" placeholder="Cidade:" value="{{ $empresa->nm_cidade }}" />
                        <label for="cidade">Cidade:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="uf" name="ds_uf" placeholder="UF:" value="{{ $empresa->ds_uf }}" />
                        <label for="uf">UF:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="cep" name="nr_cep" placeholder="CEP:"  maxlength="9" onkeypress="formatar('#####-###', this)" value="{{ $empresa->nr_cep }}" />
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
<script>
document.getElementById('tp_empresa').addEventListener('change', (e)=>{
    if(e.target.value == "Pessoa Física"){
        document.getElementById('nr_cnpj').setAttribute('maxlength', '14');
        document.getElementById('nr_cnpj').setAttribute('onkeypress', "formatar('###.###.###-##', this)");
    }
    else if(e.target.value == "Pessoa Jurídica"){
        document.getElementById('nr_cnpj').setAttribute('maxlength', '18');
        document.getElementById('nr_cnpj').setAttribute('onkeypress', "formatar('##.###.###/####-##', this)");
    }
    else{
        document.getElementById('nr_cnpj').removeAttribute('maxlength');
        document.getElementById('nr_cnpj').removeAttribute('onkeypress');
    }
})
</script>
@endsection
