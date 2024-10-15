@extends('layout.admin')

@section('conteudo')
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Adicionar Plano</h4>
        </div>
        <hr>
        <form action="{{ route('admin.planos.insert') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mt-1 gy-4">
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="nome" name="nm_plano" placeholder="Nome:"/>
                        <label for="nome">Nome:</label>
                    </div>
                </div>
            </div>
            <div class="row mt-1 gy-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="number" id="tel" name="dias_validade" placeholder="Validade(dias):"/>
                        <label for="tel">Validade(dias):</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="cel" name="vl_plano" placeholder="Valor:" onkeypress="return(MascaraMoeda(this,'.',',',event))"/>
                        <label for="cel">Valor:</label>
                    </div>
                </div>
            </div>
            <div class="row mt-1 gy-4">
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                        <textarea class="form-control h-px-100" id="descricao" name='ds_plano' placeholder="Descrição do orçamento..."></textarea>
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
