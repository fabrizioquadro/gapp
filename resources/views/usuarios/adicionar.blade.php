@extends('layout.admin')

@section('conteudo')
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Adicionar Usuário</h4>
        </div>
        <hr>
        <form action="{{ route('admin.usuarios.insert') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mt-2 gy-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="nome" name="nm_user" placeholder="Nome:"/>
                        <label for="nome">Nome:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="email" id="email" name="email" placeholder="john.doe@example.com" />
                        <label for="email">E-mail:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select required id="type" name='tp_user' class="select2 form-select">
                            <option value="">Opções</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Usuário">Usuário</option>
                        </select>
                        <label for="type">Tipo de Usuário:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select required id="genero" name='ds_genero' class="select2 form-select">
                            <option value="">Gênero</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                        <label for="genero">Gênero:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="password" id="password" name="password" placeholder="********" />
                        <label for="password">Senha:</label>
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
