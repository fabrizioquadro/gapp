@extends('layout.empresa')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('/public/template/vendor/libs/quill/typography.css') }}" />
<link rel="stylesheet" href="{{ asset('/public/template/vendor/libs/quill/katex.css') }}" />
<link rel="stylesheet" href="{{ asset('/public/template/vendor/libs/quill/editor.css') }}" />

<div class="d-flex justify-content-between">
    <h4 class="card-title">Configurações</h4>
</div>
@if($mensagem = Session::get('mensagem'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ $mensagem }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<hr>
<div class="card card-border-shadow-primary mb-4">
    <div class="card-body">
        <h6 class="card-title">Dados de Integração Asaas</h6>
        <form action="{{ route('empresa.configuracao.set_asaas') }}" method="post">
            @csrf
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select required id="asaas_method" name='asaas_method' class="select2 form-select">
                            <option @if($config && $config->asaas_method == "sandbox") selected @endif value="sandbox">sandbox</option>
                            <option @if($config && $config->asaas_method == "production") selected @endif value="production">production</option>
                        </select>
                        <label for="asaas_method">Método:</label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="asaas_client" name="asaas_client" placeholder="asaas_client" value="{{ $config ? $config->asaas_client : '' }}">
                        <label for="asaas_client">Asaas Client:</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mt-4">
                    <button type="submit" class="btn btn-secondary me-2">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card card-border-shadow-warning mb-4">
    <div class="card-body">
        <h6 class="card-title">Dados Pix</h6>
        <form action="{{ route('empresa.configuracao.set_pix') }}" method="post">
            @csrf
            <div class="row mt-3">
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <select required id="tipo_pix" name='tipo_pix' class="select2 form-select">
                            <option value=""></option>
                            <option @if($config && $config->tipo_pix == "Cpf/Cnpj") selected @endif value="Cpf/Cnpj">Cpf/Cnpj</option>
                            <option @if($config && $config->tipo_pix == "Email") selected @endif value="Email">Email</option>
                            <option @if($config && $config->tipo_pix == "Telefone") selected @endif value="Telefone">Telefone</option>
                        </select>
                        <label for="tipo_pix">Tipo da Chave:</label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="chave_pix" name="chave_pix" placeholder="Chave Pix:" value="{{ $config ? $config->chave_pix : '' }}">
                        <label for="asaas_client">Chave Pix:</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mt-4">
                    <button type="submit" class="btn btn-secondary me-2">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card card-border-shadow-warning mb-4">
    <div class="card-body">
        <form action="{{ route('empresa.configuracao.set_modelo_contrato') }}" method="post" id='form-contrato'>
            @csrf
            <input type="hidden" name="modelo_contrato" id='modelo_contrato'>
            <div class="row">
                <div class="col-md-9">
                    <h6 class="card-title">Modelo Contrato</h6>
                    <div id="full-editor">
                        @if($config && $config->modelo_contrato)
                            {!! $config->modelo_contrato !!}
                        @else
                            {!! $padrao->modelo_contrato !!}
                        @endif
                     </div>
                     <div class="row">
                         <div class="mt-4">
                             <button type="button" id='botao_salvar_modelo_contrato' class="btn btn-secondary me-2">Salvar</button>
                         </div>
                     </div>
                </div>
                <div class="col-md-3">
                    <h6 class="card-title">Macros</h6>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <b>%dados_cliente%</b><br>
                            Dados do cliente escrito por extenso.
                        </li>
                        <li class="list-group-item">
                            <b>%dados_empresa%</b><br>
                            Dados da empresa escrito por extenso.
                        </li>
                        <li class="list-group-item">
                            <b>%lista_produtos%</b><br>
                            Lista dos produtos/serviços selecionados pelo cliente
                        </li>
                        <li class="list-group-item">
                            <b>%dias_entrega%</b><br>
                            Máximo de dias dos items selecionados
                        </li>
                        <li class="list-group-item">
                            <b>%condicoes_pagamento%</b><br>
                            Descrição das formas de pagamento selecionadas pela empresa
                        </li>
                        <li class="list-group-item">
                            <b>%data_escrito%</b><br>
                            Data por extenso
                        </li>
                        <li class="list-group-item">
                            <b>%nm_cliente%</b><br>
                            Nome do Cliente
                        </li>
                        <li class="list-group-item">
                            <b>%tp_cliente%</b><br>
                            Tipo de pessoa do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_cpf%</b><br>
                            CPF ou CNPJ do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_email%</b><br>
                            Email do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_endereco%</b><br>
                            Endereço do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_numero%</b><br>
                            Número do endereço do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_complemento%</b><br>
                            Complemento do endereço do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_bairro%</b><br>
                            Bairro do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_cidade%</b><br>
                            Cidade do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_uf%</b><br>
                            UF do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_cep%</b><br>
                            CEP do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_telefone%</b><br>
                            Telefones do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%nm_empresa%</b><br>
                            Nome da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%tp_empresa%</b><br>
                            Tipo de pessoa da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_cnpj%</b><br>
                            CNPJ ou CPF da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_email%</b><br>
                            Email da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_endereco%</b><br>
                            Endereço da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_numero%</b><br>
                            Número do endereço da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_complemento%</b><br>
                            Complemento do endereço da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_bairro%</b><br>
                            Bairro da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_cidade%</b><br>
                            Cidade da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_uf%</b><br>
                            UF da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_cep%</b><br>
                            CEP da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_telefone%</b><br>
                            Telefones da empresa
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card card-border-shadow-warning mb-4">
    <div class="card-body">
        <form action="{{ route('empresa.configuracao.set_modelo_contrato_anexo') }}" method="post" id='form-contrato-anexo'>
            @csrf
            <input type="hidden" name="modelo_contrato_anexo" id='modelo_contrato_anexo'>
            <div class="row">
                <div class="col-md-9">
                    <h6 class="card-title">Modelo Contrato Anexos</h6>
                    <div id="full-editor-anexo">
                        @if($config && $config->modelo_contrato_anexo)
                            {!! $config->modelo_contrato_anexo !!}
                        @else
                            {!! $padrao->modelo_contrato_anexo !!}
                        @endif
                     </div>
                     <div class="row">
                         <div class="mt-4">
                             <button type="button" id='botao_salvar_modelo_contrato_anexo' class="btn btn-secondary me-2">Salvar</button>
                         </div>
                     </div>
                </div>
                <div class="col-md-3">
                    <h6 class="card-title">Macros</h6>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <b>%nm_anexo%</b><br>
                            Nome do anexo.
                        </li>
                        <li class="list-group-item">
                            <b>%ds_anexo%</b><br>
                            Descrição do anexo.
                        </li>
                        <li class="list-group-item">
                            <b>%vl_anexo%</b><br>
                            Valor do anexo.
                        </li>
                        <li class="list-group-item">
                            <b>%dados_cliente%</b><br>
                            Dados do cliente escrito por extenso.
                        </li>
                        <li class="list-group-item">
                            <b>%dados_empresa%</b><br>
                            Dados da empresa escrito por extenso.
                        </li>
                        <li class="list-group-item">
                            <b>%lista_produtos%</b><br>
                            Lista dos produtos/serviços selecionados pelo cliente
                        </li>
                        <li class="list-group-item">
                            <b>%dias_entrega%</b><br>
                            Máximo de dias dos items selecionados
                        </li>
                        <li class="list-group-item">
                            <b>%condicoes_pagamento%</b><br>
                            Descrição das formas de pagamento selecionadas pela empresa
                        </li>
                        <li class="list-group-item">
                            <b>%data_escrito%</b><br>
                            Data por extenso
                        </li>
                        <li class="list-group-item">
                            <b>%nm_cliente%</b><br>
                            Nome do Cliente
                        </li>
                        <li class="list-group-item">
                            <b>%tp_cliente%</b><br>
                            Tipo de pessoa do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_cpf%</b><br>
                            CPF ou CNPJ do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_email%</b><br>
                            Email do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_endereco%</b><br>
                            Endereço do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_numero%</b><br>
                            Número do endereço do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_complemento%</b><br>
                            Complemento do endereço do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_bairro%</b><br>
                            Bairro do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_cidade%</b><br>
                            Cidade do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_uf%</b><br>
                            UF do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_cep%</b><br>
                            CEP do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%cliente_telefone%</b><br>
                            Telefones do cliente
                        </li>
                        <li class="list-group-item">
                            <b>%nm_empresa%</b><br>
                            Nome da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%tp_empresa%</b><br>
                            Tipo de pessoa da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_cnpj%</b><br>
                            CNPJ ou CPF da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_email%</b><br>
                            Email da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_endereco%</b><br>
                            Endereço da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_numero%</b><br>
                            Número do endereço da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_complemento%</b><br>
                            Complemento do endereço da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_bairro%</b><br>
                            Bairro da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_cidade%</b><br>
                            Cidade da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_uf%</b><br>
                            UF da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_cep%</b><br>
                            CEP da empresa
                        </li>
                        <li class="list-group-item">
                            <b>%empresa_telefone%</b><br>
                            Telefones da empresa
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('/public/template/vendor/libs/quill/katex.js') }}"></script>
<script src="{{ asset('/public/template/vendor/libs/quill/quill.js') }}"></script>
<script>

document.getElementById('botao_salvar_modelo_contrato').addEventListener('click', ()=>{
    editor = document.querySelector('#full-editor')
    html = editor.children[0].innerHTML
    document.getElementById('modelo_contrato').value = html;
    document.getElementById('form-contrato').submit();
})

document.getElementById('botao_salvar_modelo_contrato_anexo').addEventListener('click', ()=>{
    editor = document.querySelector('#full-editor-anexo')
    html = editor.children[0].innerHTML
    document.getElementById('modelo_contrato_anexo').value = html;
    document.getElementById('form-contrato-anexo').submit();
})

window.addEventListener('load',()=>{
    const fullToolbar = [
        [
            {
                font: []
            },
            {
                size: []
            }
        ],
        ['bold', 'italic', 'underline', 'strike'],
        [
            {
                color: []
            },
            {
                background: []
            }
        ],
        [
            {
                script: 'super'
            },
            {
                script: 'sub'
            }
        ],
        [
            {
                header: '1'
            },
            {
                header: '2'
            },
            'blockquote',
            'code-block'
        ],
        [
            {
                list: 'ordered'
            },
            {
                list: 'bullet'
            },
            {
                indent: '-1'
            },
            {
                indent: '+1'
            }
        ],
        [{ direction: 'rtl' }],
        ['link', 'image', 'video', 'formula'],
        ['clean']
    ];

    const fullEditor = new Quill('#full-editor', {
      bounds: '#full-editor',
      placeholder: 'Type Something...',
      modules: {
        formula: true,
        toolbar: fullToolbar
      },
      theme: 'snow'
    });

    const fullEditorAnexo = new Quill('#full-editor-anexo', {
      bounds: '#full-editor-anexo',
      placeholder: 'Type Something...',
      modules: {
        formula: true,
        toolbar: fullToolbar
      },
      theme: 'snow'
    });

});
</script>
@endsection
