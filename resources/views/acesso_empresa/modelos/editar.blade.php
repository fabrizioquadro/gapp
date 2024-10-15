@extends('layout.empresa')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Editar Modelo de Etapas</h4>
</div>
<hr>
<div class="card card-border-shadow-primary mb-4">
    <div class="card-body">
        <form action="{{ route('empresa.modelo_etapa.update') }}" method="post">
            @csrf
            <input type="hidden" name="modelo_id" value="{{ $modelo->id }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="nome" name="nm_modelo" value="{{ $modelo->nm_modelo }}"/>
                        <label for="nome">Nome do Modelo:</label>
                    </div>
                </div>
            </div>
            <hr>
            <h6 class="card-title">Etapas</h6>
            <div class="row">
                <div class="col-md-12">
                    <p>Para adicionar as etapas basta somente digitar o nome da etapa e clicar na techa 'tab' ou 'enter'.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                        <input id="etapas" class="form-control h-auto" name="etapas"
                            value="
                            @foreach($modelo->etapas as $etapa)
                                {{ $etapa->nm_etapa.',' }}
                            @endforeach
                            "
                        />
                        <label for="etapas">Etapas</label>
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
window.addEventListener('load',()=>{
    const tagifyBasicEl = document.querySelector("#etapas");
    const TagifyBasic = new Tagify(tagifyBasicEl);
});
</script>
@endsection
