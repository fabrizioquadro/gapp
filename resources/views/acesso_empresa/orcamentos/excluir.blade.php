@extends('layout.empresa')

@section('conteudo')
    <div class="d-flex justify-content-between">
        <h4 class="card-title">Excluir Orçamento</h4>
    </div>
    <hr>
    <div class="card card-border-shadow-danger">
        <div class="card-body">
            <form action="{{ route('empresa.orcamentos.delete') }}" method="post">
                @csrf
                <input type="hidden" name="orcamento_id" value="{{ $orcamento->id }}">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            Tem certeza que deseja excluir o orçamento {{ $orcamento->titulo }}?<br>
                            Todos os dados dos produtos serão excluídos permanentemente.
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-danger me-2">Excluir</button>
                </div>
            </form>
        </div>
    </div>
@endsection
