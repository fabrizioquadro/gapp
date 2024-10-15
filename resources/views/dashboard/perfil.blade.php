@extends('layout.admin')

@section('conteudo')
@php
if($user->imagem){
    $avatar = "/public/users/imagem/$user->imagem";
}
elseif($user->ds_genero == "Masculino"){
    $avatar = '/public/template/img/avatars/1.png';
}
else{
    $avatar = '/public/template/img/avatars/2.png';
}
@endphp
<div class="card mb-4">
    <h4 class="card-header">Perfil</h4>
    <div class="card-body">
        @if($mensagem = Session::get('mensagem_erro'))
            <div class="alert alert-danger" role="alert">
                {{ $mensagem }}
            </div>
        @endif
        @if($mensagem = Session::get('mensagem_sucesso'))
            <div class="alert alert-success" role="alert">
                {{ $mensagem }}
            </div>
        @endif
        <form action="{{ route('admin.perfil.set_foto') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-start align-items-sm-center gap-4">
                <img src="{{ asset($avatar) }}" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />
                <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                        <span class="d-none d-sm-block">Enviar Nova Foto</span>
                        <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                        <input onchange="submit()" name="imagem" id="upload" type="file" class="account-file-input" hidden accept="image/png, image/jpeg" />
                    </label>
                    <button type="button" id='btnExcluirFoto' class="btn btn-outline-danger account-image-reset mb-3">
                        <i class="mdi mdi-reload d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Excluir Foto</span>
                    </button>
                    <div class="small">Somente JPG, GIF or PNG.</div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body pt-2 mt-1">
        <form action="{{ route('admin.perfil.update') }}" method="POST">
            @csrf
            <div class="row mt-2 gy-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="text" id="firstName" name="nm_user" value="{{ $user->nm_user }}" />
                        <label for="firstName">Nome:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select required id="language" name='ds_genero' class="select2 form-select">
                            <option value="">Gênero</option>
                            <option @if($user->ds_genero == "Masculino") selected @endif value="Masculino">Masculino</option>
                            <option @if($user->ds_genero == "Feminino") selected @endif value="Feminino">Feminino</option>
                        </select>
                        <label for="language">Gênero</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input required class="form-control" type="email" id="email" name="email" value="{{ $user->email }}" />
                        <label for="email">E-mail</label>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-secondary me-2">Salvar</button>
            </div>
        </form>
    </div>
<!-- /Account -->
</div>
<script>
document.getElementById('btnExcluirFoto').addEventListener('click', ()=>{
    if(confirm('Tem certeza que deseja excluir a foto?')){
        window.location.href = "{{ route('admin.perfil.excluir_foto') }}";
    }
})
</script>
@endsection
