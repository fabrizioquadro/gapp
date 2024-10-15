@extends('layout.cliente')

@section('conteudo')
<div class="d-flex justify-content-between">
    <h4 class="card-title">Alterar Senha</h4>
</div>
<hr>
<div class="card card-border-shadow-primary mb-4">
    <div class="card-body">
        <form action="{{ route('cliente.alterar_senha.update') }}" method="POST">
            @csrf
            <div class="row mt-2 gy-4">
                <div class="mb-3 col-md-6 form-password-toggle fv-plugins-icon-container">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control" type="password" name="nova_senha" id="currentPassword">
                            <label for="currentPassword">Nova Senha</label>
                        </div>
                        <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                    </div>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-secondary me-2">Alterar</button>
            </div>
        </form>
    </div>
<!-- /Account -->
</div>
@endsection
