@extends('layout.admin')

@section('conteudo')
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Editar Usuário</h4>
        </div>
        <hr>
        <form action="{{ route('admin.usuarios.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="row mt-2 gy-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="nome" name="nm_user" value="{{ $user->nm_user }}"/>
                        <label for="nome">Nome:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="email" id="email" name="email"  value="{{ $user->email }}" />
                        <label for="email">E-mail:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select required id="type" name='tp_user' class="select2 form-select">
                            <option value="">Opções</option>
                            <option @if($user->tp_user == "Administrador") selected @endif value="Administrador">Administrador</option>
                            <option @if($user->tp_user == "Usuário") selected @endif value="Usuário">Usuário</option>
                        </select>
                        <label for="type">Tipo de Usuário:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select required id="genero" name='ds_genero' class="select2 form-select">
                            <option value="">Gênero</option>
                            <option @if($user->ds_genero == "Masculino") selected @endif value="Masculino">Masculino</option>
                            <option @if($user->ds_genero == "Feminino") selected @endif value="Feminino">Feminino</option>
                        </select>
                        <label for="genero">Gênero:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="file" id="imagem" name="imagem"/>
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
