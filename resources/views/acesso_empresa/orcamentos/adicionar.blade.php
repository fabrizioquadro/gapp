@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Adicionar Orçamento</h4>
</div>
<hr>
<form action="{{ route('empresa.orcamentos.insert') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="contador_item" id='contador_item' value="1">
    <div class="card card-border-shadow-primary">
        <div class="card-body">
            <h6 class="card-title">Orçamento</h6>
            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="form-floating form-floating-outline">
                        <select required id="cliente" name='cliente_id' class="select2 form-select">
                            <option value="">Cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nm_cliente }}</option>
                            @endforeach
                        </select>
                        <label for="cliente">Cliente:</label>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="titulo" name="titulo" placeholder="Título:"/>
                        <label for="titulo">Título:</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="number" id="validade" name="validade" placeholder="Validade (dias):"/>
                        <label for="validade">Validade (dias):</label>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="file" id="arquivos" name="arquivos[]" multiple placeholder="Anexos:"/>
                        <label for="arquivos">Anexos:</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="form-floating form-floating-outline">
                        <textarea class="form-control h-px-100" id="descricao" name='descricao' placeholder="Descrição do orçamento..."></textarea>
                        <label for="descricao">Descrição:</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-border-shadow-warning mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h6 class="card-title">Produtos / Serviços</h6>
                <button type="button" class="btn btn-sm btn-warning" id="btn_add_item">Adicionar</button>
            </div>
            <div id='div_items'>
                <div class="card card-border-shadow-secondary mt-3">
                    <div class="card-body">
                        <h6 class="card-title">Item 1</h6>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="form-floating form-floating-outline">
                                    <input required class="form-control" type="text" id="nm_produto1" name="nm_produto1" placeholder="Nome:"/>
                                    <label for="nm_produto1">Nome:</label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-floating form-floating-outline">
                                    <input required class="form-control" type="text" id="vl_produto1" name="vl_produto1" placeholder="Valor:" onkeypress="return(MascaraMoeda(this,'.',',',event))"/>
                                    <label for="vl_produto1">Valor:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="form-floating form-floating-outline">
                                    <input required class="form-control" type="number" id="dt_entrega1" name="dias_entrega1" placeholder="Entrega (dias):"/>
                                    <label for="dt_entrega1">Entrega (dias):</label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="file" id="arquivos_item1" name="arquivos_item1[]" multiple placeholder="Anexos:"/>
                                    <label for="arquivos_item1">Anexos:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="form-floating form-floating-outline">
                                    <textarea class="form-control h-px-100" id="ds_produto1" name="ds_produto1" placeholder="Descrição do Produto/Serviço ..."></textarea>
                                    <label for="ds_produto1">Descrição:</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h6 class="card-title">Etapas para entraga</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <select onchange="busca_etapas_modelo(1)" id="modelo1" class="select2 form-select">
                                        <option value=""></option>
                                        @foreach($modelos as $modelo)
                                            <option value="{{ $modelo->id }}">{{ $modelo->nm_modelo }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modelo1">Modelo:</label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline">
                                    <input id="etapas1" class="form-control h-auto" name="etapas1" value="" />
                                    <label for="etapas1">Etapas</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    window.addEventListener('load',()=>{
        tagifyBasicEl = document.querySelector("#etapas1");
        TagifyBasic = new Tagify(tagifyBasicEl);
    });
    </script>
    <div class="card card-border-shadow-success mt-3">
        <div class="card-body">
            <h6 class="card-title">Formas de Pagamento</h6>
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <b>Pagamento Ávista:</b><br>
                        Informe a porcentagem de desconto para pagamento àvista nas formas de pix e boleto ou cartão de crédito.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="number" id="avista" name="desconto_avista" placeholder="Desconto Àvista(%):"/>
                        <label for="avista">Desconto Ávista(%):</label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-md-12">
                    <p>
                        <b>Parcelamento Cartão de Crédito:</b><br>
                        Informe o número de vezes que o cliente poderá parcelar no cartão de crédito.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="number" id="cartao" name="parcelamento_cartao" placeholder="Parcelamento Cartão Crédito:"/>
                        <label for="cartao">Parcelamento Cartão Crédito:</label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-md-12">
                    <p>
                        <b>Entrada + Sado Devedor:</b><br>
                        Informe a porcentagem de entrada juntamente com a data do vencimento e a quantidade de vezes que o saldo devedor poderá ser dividido, estes pagamentos serão gerados através do pix.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="number" id="parcelamento_entrada" name="parcelamento_entrada" placeholder="Porcentagem Entrada(%):"/>
                        <label for="parcelamento_entrada">Porcentagem Entrada(%):</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="date" id="vencimento_entrada" name="vencimento_entrada" placeholder="Vencimento Entrada:"/>
                        <label for="vencimento_entrada">Vencimento Entrada:</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="number" id="parcelamento_vezes" name="parcelamento_vezes" placeholder="Número de vezes Saldo Devedor:"/>
                        <label for="parcelamento_vezes">Número de vezes Saldo Devedor:</label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <b>Entrada + Entrega:</b><br>
                        Informe a porcentagem de entrada juntamente com a data do vencimento, o restante vai ter o vencimento para a data de entrega do produto/serviço.<br>
                        Forma de pagamento PIX.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="number" id="entrega_entrada" name="entrega_entrada" placeholder="Porcentagem Entrada(%):"/>
                        <label for="entrega_entrada">Porcentagem Entrada(%):</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="date" id="entrega_vencimento" name="entrega_vencimento" placeholder="Vencimento Entrada:"/>
                        <label for="entrega_vencimento">Vencimento Entrada:</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-1 gy-4">
        <div class="col-md-6">
            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" name="enviar_email_cliente" checked value="sim">
                <label class="form-check-label" for="defaultCheck1"> Enviar email aviso ao cliente? </label>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <button type="submit" class="btn btn-secondary me-2">Salvar</button>
    </div>
</form>
<script>
function busca_etapas_modelo(numero){
    modelo_id = document.getElementById('modelo' + numero).value;
    if(modelo_id){
        $.getJSON(
            "{{ route('empresa.orcamentos.busca_modelo_etapa') }}/",
            {
                modelo_id : modelo_id
            },
            function(json){
                document.getElementById('etapas' + numero).value = json.etapas;
            }
        );
    }
    else{
        document.getElementById('etapas' + numero).value = '';
    }
}

document.getElementById('btn_add_item').addEventListener('click', ()=>{
    contador = parseInt(document.getElementById('contador_item').value);
    contador++;
    document.getElementById('contador_item').value = contador;

    card = document.createElement('div');
    card.setAttribute('class','card card-border-shadow-secondary mt-3');
    card_body = document.createElement('div');
    card_body.setAttribute('class','card-body');
    h6 = document.createElement('h6');
    h6.setAttribute('class','card-title');
    h6.innerHTML = "Item " + contador;

    card_body.appendChild(h6);

    row1 = document.createElement('div');
    row1.setAttribute('class','row');
    col11 = document.createElement('div');
    col11.setAttribute('class','col-md-6 mt-3');
    col_form11 = document.createElement('div');
    col_form11.setAttribute('class','form-floating form-floating-outline');
    input11 = document.createElement('input');
    input11.setAttribute('class','form-control');
    input11.setAttribute('type','text');
    input11.setAttribute('id','nm_produto' + contador);
    input11.setAttribute('name','nm_produto' + contador);
    input11.setAttribute('placeholder','Nome:');
    label11 = document.createElement('label');
    label11.setAttribute('for','nm_produto' + contador);
    label11.innerHTML = "Nome:";
    col_form11.appendChild(input11);
    col_form11.appendChild(label11);
    col11.appendChild(col_form11);
    row1.appendChild(col11);

    col12 = document.createElement('div');
    col12.setAttribute('class','col-md-6 mt-3');
    col_form12 = document.createElement('div');
    col_form12.setAttribute('class','form-floating form-floating-outline');
    input12 = document.createElement('input');
    input12.setAttribute('class','form-control');
    input12.setAttribute('type','text');
    input12.setAttribute('id','vl_produto' + contador);
    input12.setAttribute('name','vl_produto' + contador);
    input12.setAttribute('placeholder','Valor:');
    input12.setAttribute('onkeypress',"return(MascaraMoeda(this,'.',',',event))");
    label12 = document.createElement('label');
    label12.setAttribute('for','vl_produto' + contador);
    label12.innerHTML = "Valor:";
    col_form12.appendChild(input12);
    col_form12.appendChild(label12);
    col12.appendChild(col_form12);
    row1.appendChild(col12);

    card_body.appendChild(row1);

    row2 = document.createElement('div');
    row2.setAttribute('class','row');
    col21 = document.createElement('div');
    col21.setAttribute('class','col-md-6 mt-3');
    col_form21 = document.createElement('div');
    col_form21.setAttribute('class','form-floating form-floating-outline');
    input21 = document.createElement('input');
    input21.setAttribute('class','form-control');
    input21.setAttribute('type','number');
    input21.setAttribute('id','dt_entrega' + contador);
    input21.setAttribute('name','dias_entrega' + contador);
    input21.setAttribute('placeholder','Entrega (dias):');
    label21 = document.createElement('label');
    label21.setAttribute('for','dt_entrega' + contador);
    label21.innerHTML = "Entrega (dias):";
    col_form21.appendChild(input21);
    col_form21.appendChild(label21);
    col21.appendChild(col_form21);
    row2.appendChild(col21);

    col22 = document.createElement('div');
    col22.setAttribute('class','col-md-6 mt-3');
    col_form22 = document.createElement('div');
    col_form22.setAttribute('class','form-floating form-floating-outline');
    input22 = document.createElement('input');
    input22.setAttribute('class','form-control');
    input22.setAttribute('type','file');
    input22.setAttribute('id','arquivos_item' + contador);
    input22.setAttribute('name','arquivos_item' + contador + '[]');
    input22.setAttribute('placeholder','Anexos:');
    input22.setAttribute('multiple',"multiple");
    label22 = document.createElement('label');
    label22.setAttribute('for','arquivos_item' + contador);
    label22.innerHTML = "Anexos:";
    col_form22.appendChild(input22);
    col_form22.appendChild(label22);
    col22.appendChild(col_form22);
    row2.appendChild(col22);

    card_body.appendChild(row2);

    row3 = document.createElement('div');
    row3.setAttribute('class','row');
    col3 = document.createElement('div');
    col3.setAttribute('class','col-md-12 mt-3');
    col_form3 = document.createElement('div');
    col_form3.setAttribute('class','form-floating form-floating-outline');
    textarea3 = document.createElement('textarea');
    textarea3.setAttribute('class','form-control h-px-100');
    textarea3.setAttribute('id','ds_produto' + contador);
    textarea3.setAttribute('name','ds_produto' + contador);
    textarea3.setAttribute('placeholder','Descrição do Produto/Serviço ...');
    label3 = document.createElement('label');
    label3.setAttribute('for','ds_produto' + contador);
    label3.innerHTML = "Descrição:";
    col_form3.appendChild(textarea3);
    col_form3.appendChild(label3);
    col3.appendChild(col_form3);
    row3.appendChild(col3);

    card_body.appendChild(row3);

    //vamos adicionar a parte das etapas
    hr = document.createElement('hr');
    card_body.appendChild(hr);
    card_title = document.createElement('h6');
    card_title.setAttribute('class', 'card-title');
    card_title.innerHTML = 'Etapas para entraga';
    card_body.appendChild(card_title);

    row_etapas = document.createElement('div');
    row_etapas.setAttribute('class','row');

    etapas_col1 = document.createElement('div');
    etapas_col1.setAttribute('class','col-md-4');
    etapas_col1_form = document.createElement('div');
    etapas_col1_form.setAttribute('class','form-floating form-floating-outline');
    select_etapas = document.createElement('select');
    select_etapas.setAttribute('class', 'select2 form-select');
    select_etapas.setAttribute('onchange', "busca_etapas_modelo("+ contador +")");
    select_etapas.setAttribute('id', "modelo" + contador);
    select_etapas.innerHTML = document.getElementById('modelo1').innerHTML;
    label_etapas = document.createElement('label');
    label_etapas.innerHTML = 'Modelo:';
    etapas_col1_form.appendChild(select_etapas);
    etapas_col1_form.appendChild(label_etapas);
    etapas_col1.appendChild(etapas_col1_form);
    row_etapas.appendChild(etapas_col1);

    etapas_col2 = document.createElement('div');
    etapas_col2.setAttribute('class','col-md-8');
    etapas_col2_form = document.createElement('div');
    etapas_col2_form.setAttribute('class','form-floating form-floating-outline');
    input_etapas = document.createElement('input');
    input_etapas.setAttribute('class', 'form-control h-auto');
    input_etapas.setAttribute('id', "etapas" + contador);
    input_etapas.setAttribute('name', "etapas" + contador);
    label_etapas_input = document.createElement('label');
    label_etapas_input.innerHTML = 'Etapas:';
    etapas_col2_form.appendChild(input_etapas);
    etapas_col2_form.appendChild(label_etapas_input);
    etapas_col2.appendChild(etapas_col2_form);
    row_etapas.appendChild(etapas_col2);

    card_body.appendChild(row_etapas);

    card.appendChild(card_body);
    document.getElementById('div_items').appendChild(card);

    tagifyBasicEl = document.querySelector("#etapas" + contador);
    TagifyBasic = new Tagify(tagifyBasicEl);

});
</script>
@endsection
