@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Adquirir Plano</h4>
</div>
<hr>
<div class="row">
    <div class="col-md-8">
        <form action="{{ route('empresa.planos.comprar') }}" method="post">
            @csrf
            <input type="hidden" name="plano_id" value="{{ $plano->id }}">
            <div class="card mt-3 card-border-shadow-success">
                <div class="card-body">
                    <h6 class="card-title">Cartão de Crédito</h6>
                    <p>
                        Plano: <b>{{ $plano->nm_plano }}</b><br>
                        Descrição: <b>{{ $plano->ds_plano }}</b><br>
                        Validade: <b>{{ $plano->dias_validade }}</b><br>
                        Valor: <b>{{ 'R$ '.valorDbForm($plano->vl_plano) }}</b><br>
                    </p>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input required class="form-control" type="text" id="nr_cartao" name="nr_cartao" placeholder="Número do Cartão:" maxlength="16" />
                                <label for="nr_cartao">Número do Cartão:</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <div class="form-floating form-floating-outline">
                                <input required class="form-control" type="text" id="nm_cartao" name="nm_cartao" placeholder="Nome no Cartão:" />
                                <label for="nm_cartao">Nome no Cartão:</label>
                            </div>
                        </div>
                        <div class="col-md-3 mt-3">
                            <div class="form-floating form-floating-outline">
                                <input required class="form-control" type="text" id="nr_codigo" name="nr_codigo" placeholder="Código Segurança:" />
                                <label for="nr_codigo">Código Segurança:</label>
                            </div>
                        </div>
                        <div class="col-md-3 mt-3">
                            <div class="form-floating form-floating-outline">
                                <input required class="form-control" type="text" id="vencimento_cartao" name="vencimento_cartao" placeholder="Vencimento:" maxlength="5" onkeypress="formatar('##/##', this)"/>
                                <label for="vencimento_cartao">Vencimento:</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4" align='right'>
                        <button type="submit" class="btn btn-secondary me-2">Comprar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
