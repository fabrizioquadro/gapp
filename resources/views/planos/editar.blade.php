@extends('layout.admin')

@section('conteudo')
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Editar Plano</h4>
        </div>
        <hr>
        <form action="{{ route('admin.planos.update') }}" method="post">
            @csrf
            <input type="hidden" name="plano_id" value="{{ $plano->id }}">
            <div class="row mt-1 gy-4">
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="nome" name="nm_plano" placeholder="Nome:" value="{{ $plano->nm_plano }}"/>
                        <label for="nome">Nome:</label>
                    </div>
                </div>
            </div>
            <div class="row mt-1 gy-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="number" id="tel" name="dias_validade" placeholder="Validade(dias):" value="{{ $plano->dias_validade }}"/>
                        <label for="tel">Validade(dias):</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="cel" name="vl_plano" placeholder="Valor:" onkeypress="return(MascaraMoeda(this,'.',',',event))" value="{{ valorDbForm($plano->vl_plano) }}"/>
                        <label for="cel">Valor:</label>
                    </div>
                </div>
            </div>
            <div class="row mt-1 gy-4">
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                        <textarea class="form-control h-px-100" id="descricao" name='ds_plano' placeholder="Descrição do orçamento...">{{ $plano->ds_plano }}</textarea>
                        <label for="descricao">Descrição:</label>
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
