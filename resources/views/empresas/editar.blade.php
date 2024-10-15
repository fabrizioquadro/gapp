@extends('layout.admin')

@section('conteudo')
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Editar Empresa</h4>
        </div>
        <hr>
        <form action="{{ route('admin.empresas.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
            <div class="row mt-1 gy-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="nome" name="nm_empresa" placeholder="Nome:" value="{{ $empresa->nm_empresa }}"/>
                        <label for="nome">Nome:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="email" id="email" name="ds_email"  value="{{ $empresa->ds_email }}" />
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
            <div class="row mt-1 gy-4">
                <div class="col-md-12 form-group">
                    <label for="">Descrição da Empresa</label>
                    <textarea name="ds_empresa" id='ds_empresa'>{{ $empresa->ds_empresa }}</textarea>
                </div>
            </div>
            <div class="row mt-1 gy-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select required id="situacao" name='st_empresa' class="select2 form-select">
                            <option></option>
                            <option @if($empresa->st_empresa == "Liberada") selected @endif value="Liberada">Liberada</option>
                            <option @if($empresa->st_empresa == "Trancada") selected @endif value="Trancada">Trancada</option>
                        </select>
                        <label for="genero">Situação:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="file" id="imagem" name="imagem"/>
                        <label for="imagem">Imagem:</label>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-secondary me-2">Salvar</button>
            </div>
        </form>
    </div>
</div>
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/"
        }
    }
</script>
<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Font,
        Paragraph
    } from 'ckeditor5';

    ClassicEditor.create( document.querySelector( '#ds_empresa' ), {
        plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
        toolbar: {
            items: [
                'undo', 'redo', '|', 'bold', 'italic', '|','fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        }
    } )
    .catch( error => {
        console.error( error );
    } );
</script>
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
