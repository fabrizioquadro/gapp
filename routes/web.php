<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\DashboardEmpresaController;
use App\Http\Controllers\UsuarioEmpresaController;
use App\Http\Controllers\ClienteEmpresaController;
use App\Http\Controllers\OrcamentoEmpresaController;
use App\Http\Controllers\DashboardClienteController;
use App\Http\Controllers\OrcamentoClienteController;
use App\Http\Controllers\ConfiguracaoEmpresaController;
use App\Http\Controllers\ProjetoClienteController;
use App\Http\Controllers\ModeloEmpresaController;
use App\Http\Controllers\ProjetoEmpresaController;
use App\Http\Controllers\PlanoController;
use App\Http\Controllers\PlanoEmpresaController;
use App\Http\Controllers\MensagemEmpresaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'admin_index'])->name('admin.index');
Route::post('/admin/login', [LoginController::class, 'admin_login'])->name('admin.login');
Route::get('/admin/recuperar_senha', [LoginController::class, 'admin_recuperar_senha'])->name('admin.recuperar_senha');
Route::post('/admin/gerar_nova_senha', [LoginController::class, 'admin_gerar_nova_senha'])->name('admin.gerar_nova_senha');

Route::get('/empresa', [LoginController::class, 'empresa_index'])->name('empresa.index');
Route::get('/empresa/register', [LoginController::class, 'empresa_register'])->name('empresa.register');
Route::post('/empresa/register/insert', [LoginController::class, 'empresa_register_insert'])->name('empresa.register.insert');
Route::post('/empresa/login', [LoginController::class, 'empresa_login'])->name('empresa.login');
Route::get('/empresa/recuperar_senha', [LoginController::class, 'empresa_recuperar_senha'])->name('empresa.recuperar_senha');
Route::post('/empresa/gerar_nova_senha', [LoginController::class, 'empresa_gerar_nova_senha'])->name('empresa.gerar_nova_senha');

Route::get('/cliente', [LoginController::class, 'cliente_index'])->name('cliente.index');
Route::post('/cliente/login', [LoginController::class, 'cliente_login'])->name('cliente.login');
Route::get('/cliente/recuperar_senha', [LoginController::class, 'cliente_recuperar_senha'])->name('cliente.recuperar_senha');
Route::post('/cliente/gerar_nova_senha', [LoginController::class, 'cliente_gerar_nova_senha'])->name('cliente.gerar_nova_senha');

Route::middleware(['auth'])->group(function () {
    // rotas de acesso resttito ao administrador
    Route::prefix('admin')->group(function(){
        Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/perfil', [DashboardController::class, 'perfil'])->name('admin.perfil');
        Route::post('/perfil/update', [DashboardController::class, 'perfil_update'])->name('admin.perfil.update');
        Route::post('/perfil/set_foto', [DashboardController::class, 'perfil_set_foto'])->name('admin.perfil.set_foto');
        Route::get('/perfil/excluir_foto', [DashboardController::class, 'perfil_excluir_foto'])->name('admin.perfil.excluir_foto');
        Route::get('/alterar_senha', [DashboardController::class, 'alterar_senha'])->name('admin.alterar_senha');
        Route::post('/alterar_senha/update', [DashboardController::class, 'alterar_senha_update'])->name('admin.alterar_senha.update');

        Route::get('usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios');
        Route::get('usuarios/adicionar', [UsuarioController::class, 'adicionar'])->name('admin.usuarios.adicionar');
        Route::get('usuarios/editar/{id}', [UsuarioController::class, 'editar'])->name('admin.usuarios.editar');
        Route::get('usuarios/excluir/{id}', [UsuarioController::class, 'excluir'])->name('admin.usuarios.excluir');
        Route::get('usuarios/alterar_senha/{id}', [UsuarioController::class, 'alterar_senha'])->name('admin.usuarios.alterar_senha');
        Route::post('usuarios/insert', [UsuarioController::class, 'insert'])->name('admin.usuarios.insert');
        Route::post('usuarios/update', [UsuarioController::class, 'update'])->name('admin.usuarios.update');
        Route::post('usuarios/alterar_senha/update', [UsuarioController::class, 'alterar_senha_update'])->name('admin.usuarios.alterar_senha.update');
        Route::post('usuarios/delete', [UsuarioController::class, 'delete'])->name('admin.usuarios.delete');

        Route::get('empresas', [EmpresaController::class, 'index'])->name('admin.empresas');
        Route::get('empresas/adicionar', [EmpresaController::class, 'adicionar'])->name('admin.empresas.adicionar');
        Route::post('empresas/insert', [EmpresaController::class, 'insert'])->name('admin.empresas.insert');
        Route::get('empresas/editar/{id}', [EmpresaController::class, 'editar'])->name('admin.empresas.editar');
        Route::get('empresas/excluir/{id}', [EmpresaController::class, 'excluir'])->name('admin.empresas.excluir');
        Route::get('empresas/alterar_senha/{id}', [EmpresaController::class, 'alterar_senha'])->name('admin.empresas.alterar_senha');
        Route::get('empresas/visualizar/{id}', [EmpresaController::class, 'visualizar'])->name('admin.empresas.visualizar');
        Route::post('empresas/update', [EmpresaController::class, 'update'])->name('admin.empresas.update');
        Route::post('empresas/alterar_senha/update', [EmpresaController::class, 'alterar_senha_update'])->name('admin.empresas.alterar_senha.update');
        Route::post('empresas/delete', [EmpresaController::class, 'delete'])->name('admin.empresas.delete');
        Route::get('empresas/mensagens/{id}', [EmpresaController::class, 'mensagens'])->name('admin.empresas.mensagens');
        Route::post('empresas/mensagens/insert', [EmpresaController::class, 'mensagem_insert'])->name('admin.empresas.mensagens.insert');

        Route::get('planos', [PlanoController::class, 'index'])->name('admin.planos');
        Route::get('planos/adicionar', [PlanoController::class, 'adicionar'])->name('admin.planos.adicionar');
        Route::get('planos/editar/{id}', [PlanoController::class, 'editar'])->name('admin.planos.editar');
        Route::get('planos/excluir/{id}', [PlanoController::class, 'excluir'])->name('admin.planos.excluir');
        Route::post('planos/insert', [PlanoController::class, 'insert'])->name('admin.planos.insert');
        Route::post('planos/update', [PlanoController::class, 'update'])->name('admin.planos.update');
        Route::post('planos/delete', [PlanoController::class, 'delete'])->name('admin.planos.delete');

    });
});

Route::middleware('verificaSessaoEmpresa')->group(function(){
    Route::prefix('empresa')->group(function(){
        Route::get('/logout', [LoginController::class, 'logout_empresa'])->name('empresa.logout');

        Route::get('/dashboard', [DashboardEmpresaController::class, 'index'])->name('empresa.dashboard');
        Route::get('/perfil', [DashboardEmpresaController::class, 'perfil'])->name('empresa.perfil');
        Route::get('/alterar_senha', [DashboardEmpresaController::class, 'alterar_senha'])->name('empresa.alterar_senha');
        Route::post('/perfil/update', [DashboardEmpresaController::class, 'perfil_update'])->name('empresa.perfil.update');
        Route::post('/perfil/set_foto', [DashboardEmpresaController::class, 'perfil_set_foto'])->name('empresa.perfil.set_foto');
        Route::post('/alterar_senha/update', [DashboardEmpresaController::class, 'alterar_senha_update'])->name('empresa.alterar_senha.update');
        Route::get('/usuario/perfil', [DashboardEmpresaController::class, 'perfil_usuario'])->name('empresa.usuario.perfil');
        Route::get('/usuario/alterar_senha', [DashboardEmpresaController::class, 'alterar_senha_usuario'])->name('empresa.usuario.alterar_senha');
        Route::post('/usuario/perfil/set_foto', [DashboardEmpresaController::class, 'perfil_usuario_set_foto'])->name('empresa.usuario.perfil.set_foto');
        Route::post('/usuario/perfil/update', [DashboardEmpresaController::class, 'perfil_usuario_update'])->name('empresa.usuario.perfil.update');
        Route::post('/usuario/alterar_senha/update', [DashboardEmpresaController::class, 'usuario_alterar_senha_update'])->name('empresa.usuario.alterar_senha.update');

        Route::get('/usuarios', [UsuarioEmpresaController::class, 'index'])->name('empresa.usuarios');
        Route::get('/usuarios/adicionar', [UsuarioEmpresaController::class, 'adicionar'])->name('empresa.usuarios.adicionar');
        Route::get('/usuarios/editar/{id}', [UsuarioEmpresaController::class, 'editar'])->name('empresa.usuarios.editar');
        Route::get('/usuarios/excluir/{id}', [UsuarioEmpresaController::class, 'excluir'])->name('empresa.usuarios.excluir');
        Route::get('/usuarios/alterar_senha/{id}', [UsuarioEmpresaController::class, 'alterar_senha'])->name('empresa.usuarios.alterar_senha');
        Route::post('/usuarios/insert', [UsuarioEmpresaController::class, 'insert'])->name('empresa.usuarios.insert');
        Route::post('/usuarios/update', [UsuarioEmpresaController::class, 'update'])->name('empresa.usuarios.update');
        Route::post('/usuarios/delete', [UsuarioEmpresaController::class, 'delete'])->name('empresa.usuarios.delete');
        Route::post('/usuarios/alterar_senha/update', [UsuarioEmpresaController::class, 'alterar_senha_update'])->name('empresa.usuarios.alterar_senha.update');

        Route::get('/clientes', [ClienteEmpresaController::class, 'index'])->name('empresa.clientes');
        Route::get('/clientes/adicionar', [ClienteEmpresaController::class, 'adicionar'])->name('empresa.clientes.adicionar');
        Route::get('/clientes/editar/{id}', [ClienteEmpresaController::class, 'editar'])->name('empresa.clientes.editar');
        Route::get('/clientes/excluir/{id}', [ClienteEmpresaController::class, 'excluir'])->name('empresa.clientes.excluir');
        Route::get('/clientes/alterar_senha/{id}', [ClienteEmpresaController::class, 'alterar_senha'])->name('empresa.clientes.alterar_senha');
        Route::get('/clientes/visualizar/{id}', [ClienteEmpresaController::class, 'visualizar'])->name('empresa.clientes.visualizar');
        Route::get('/clientes/enviar_email_acesso/{id}', [ClienteEmpresaController::class, 'enviar_email_acesso'])->name('empresa.clientes.enviar_email_acesso');
        Route::post('/clientes/insert', [ClienteEmpresaController::class, 'insert'])->name('empresa.clientes.insert');
        Route::post('/clientes/update', [ClienteEmpresaController::class, 'update'])->name('empresa.clientes.update');
        Route::post('/clientes/delete', [ClienteEmpresaController::class, 'delete'])->name('empresa.clientes.delete');
        Route::post('/clientes/alterar_senha/update', [ClienteEmpresaController::class, 'alterar_senha_update'])->name('empresa.clientes.alterar_senha.update');
        Route::post('/clientes/enviar_email_acesso/send', [ClienteEmpresaController::class, 'enviar_email_acesso_send'])->name('empresa.clientes.enviar_email_acesso.send');

        Route::get('/orcamentos', [OrcamentoEmpresaController::class, 'index'])->name('empresa.orcamentos');
        Route::get('/orcamentos/adicionar', [OrcamentoEmpresaController::class, 'adicionar'])->name('empresa.orcamentos.adicionar');
        Route::get('/orcamentos/excluir/{id}', [OrcamentoEmpresaController::class, 'excluir'])->name('empresa.orcamentos.excluir');
        Route::get('/orcamentos/acessar/{id}', [OrcamentoEmpresaController::class, 'acessar'])->name('empresa.orcamentos.acessar');
        Route::get('/orcamentos/arquivos/delete/{id?}', [OrcamentoEmpresaController::class, 'delete_arquivo_orcamento'])->name('empresa.orcamentos.arquivos.delete');
        Route::get('/orcamentos/produto/arquivos/delete/{id?}', [OrcamentoEmpresaController::class, 'delete_arquivo_produto'])->name('empresa.orcamentos.produto.arquivos.delete');
        Route::get('/orcamentos/produto/buscar', [OrcamentoEmpresaController::class, 'buscar_produto'])->name('empresa.orcamentos.produto.buscar');
        Route::get('/orcamentos/enviar_email_cliente/{id}', [OrcamentoEmpresaController::class, 'enviar_email_cliente'])->name('empresa.orcamentos.enviar_email_cliente');
        Route::post('/orcamentos/insert', [OrcamentoEmpresaController::class, 'insert'])->name('empresa.orcamentos.insert');
        Route::post('/orcamentos/update', [OrcamentoEmpresaController::class, 'update'])->name('empresa.orcamentos.update');
        Route::post('/orcamentos/delete', [OrcamentoEmpresaController::class, 'delete'])->name('empresa.orcamentos.delete');
        Route::post('/orcamentos/produto/update', [OrcamentoEmpresaController::class, 'update_produto'])->name('empresa.orcamentos.produto.update');
        Route::post('/orcamentos/forma_pagamento/update', [OrcamentoEmpresaController::class, 'update_forma_pagamento'])->name('empresa.orcamentos.forma_pagamento.update');
        Route::get('/orcamentos/busca_modelo_etapa', [OrcamentoEmpresaController::class, 'busca_modelo_etapa'])->name('empresa.orcamentos.busca_modelo_etapa');

        Route::get('/projetos', [ProjetoEmpresaController::class, 'index'])->name('empresa.projetos');
        Route::get('/projetos/acessar/{id}', [ProjetoEmpresaController::class, 'acessar'])->name('empresa.projetos.acessar');
        Route::get('/projetos/anexos/buscar', [ProjetoEmpresaController::class, 'buscar_anexo'])->name('empresa.projetos.anexos.buscar');
        Route::get('/projetos/anexos/arquivos/excluir', [ProjetoEmpresaController::class, 'excluir_arquivo_anexo'])->name('empresa.projetos.anexos.arquivos.excluir');
        Route::post('/projetos/anexos/adicionar', [ProjetoEmpresaController::class, 'adicionar_anexo'])->name('empresa.projetos.anexos.adicionar');
        Route::post('/projetos/anexos/update', [ProjetoEmpresaController::class, 'update_anexo'])->name('empresa.projetos.anexos.update');
        Route::get('/projetos/anexos/delete/{id?}', [ProjetoEmpresaController::class, 'delete_anexo'])->name('empresa.projetos.anexos.delete');
        Route::get('/projetos/financeiro/set_pagamento/{id?}', [ProjetoEmpresaController::class, 'set_pagamento'])->name('empresa.projetos.financeiro.set_pagamento');
        Route::get('/projetos/anexos/financeiro/set_pagamento/{id?}', [ProjetoEmpresaController::class, 'set_pagamento_anexo'])->name('empresa.projetos.anexos.financeiro.set_pagamento');
        Route::get('/projetos/financeiro/cancela_pagamento/{id?}', [ProjetoEmpresaController::class, 'cancela_pagamento'])->name('empresa.projetos.financeiro.cancela_pagamento');
        Route::get('/projetos/anexos/financeiro/cancela_pagamento/{id?}', [ProjetoEmpresaController::class, 'cancela_pagamento_anexo'])->name('empresa.projetos.anexos.financeiro.cancela_pagamento');
        Route::get('/projetos/etapas/set_etapa', [ProjetoEmpresaController::class, 'set_etapa'])->name('empresa.projetos.etapas.set_etapa');
        Route::post('/projetos/observacao/adicionar', [ProjetoEmpresaController::class, 'adicionar_observacao'])->name('empresa.projetos.observacao.adicionar');
        Route::post('/projetos/finalizar', [ProjetoEmpresaController::class, 'finalizar_projeto'])->name('empresa.projetos.finalizar');

        Route::get('/modelo_etapa', [ModeloEmpresaController::class, 'index'])->name('empresa.modelo_etapa');
        Route::get('/modelo_etapa/adicionar', [ModeloEmpresaController::class, 'adicionar'])->name('empresa.modelo_etapa.adicionar');
        Route::get('/modelo_etapa/editar/{id}', [ModeloEmpresaController::class, 'editar'])->name('empresa.modelo_etapa.editar');
        Route::get('/modelo_etapa/excluir/{id}', [ModeloEmpresaController::class, 'excluir'])->name('empresa.modelo_etapa.excluir');
        Route::get('/modelo_etapa/visualizar/{id}', [ModeloEmpresaController::class, 'visualizar'])->name('empresa.modelo_etapa.visualizar');
        Route::post('/modelo_etapa/insert', [ModeloEmpresaController::class, 'insert'])->name('empresa.modelo_etapa.insert');
        Route::post('/modelo_etapa/update', [ModeloEmpresaController::class, 'update'])->name('empresa.modelo_etapa.update');
        Route::post('/modelo_etapa/delete', [ModeloEmpresaController::class, 'delete'])->name('empresa.modelo_etapa.delete');

        Route::get('/configuracao', [ConfiguracaoEmpresaController::class, 'index'])->name('empresa.configuracao');
        Route::post('/configuracao/asaas', [ConfiguracaoEmpresaController::class, 'set_asaas'])->name('empresa.configuracao.set_asaas');
        Route::post('/configuracao/pix', [ConfiguracaoEmpresaController::class, 'set_pix'])->name('empresa.configuracao.set_pix');
        Route::post('/configuracao/modelo_contrato', [ConfiguracaoEmpresaController::class, 'set_modelo_contrato'])->name('empresa.configuracao.set_modelo_contrato');
        Route::post('/configuracao/modelo_contrato_anexo', [ConfiguracaoEmpresaController::class, 'set_modelo_contrato_anexo'])->name('empresa.configuracao.set_modelo_contrato_anexo');

        Route::get('/planos', [PlanoEmpresaController::class, 'index'])->name('empresa.planos');
        Route::get('/planos/adquirir/{id}', [PlanoEmpresaController::class, 'adquirir'])->name('empresa.planos.adquirir');
        Route::post('/planos/comprar', [PlanoEmpresaController::class, 'comprar'])->name('empresa.planos.comprar');

        Route::get('/mensagens', [MensagemEmpresaController::class, 'index'])->name('empresa.mensagens');
        Route::post('/mensagens/insert', [MensagemEmpresaController::class, 'insert'])->name('empresa.mensagens.insert');
    });
});

Route::middleware('verificaSessaoCliente')->group(function(){
    Route::prefix('cliente')->group(function(){
        Route::get('/logout', [LoginController::class, 'logout_cliente'])->name('cliente.logout');

        Route::get('/dashboard', [DashboardClienteController::class, 'index'])->name('cliente.dashboard');
        Route::get('/perfil', [DashboardClienteController::class, 'perfil'])->name('cliente.perfil');
        Route::post('/perfil/update', [DashboardClienteController::class, 'perfil_update'])->name('cliente.perfil.update');
        Route::get('/alterar_senha', [DashboardClienteController::class, 'alterar_senha'])->name('cliente.alterar_senha');
        Route::post('/alterar_senha', [DashboardClienteController::class, 'alterar_senha_update'])->name('cliente.alterar_senha.update');

        Route::get('/orcamentos', [OrcamentoClienteController::class, 'index'])->name('cliente.orcamentos');
        Route::get('/orcamentos/acessar/{id?}', [OrcamentoClienteController::class, 'acessar'])->name('cliente.orcamentos.acessar');
        Route::get('/orcamentos/monta_pagamento', [OrcamentoClienteController::class, 'monta_pagamento'])->name('cliente.orcamentos.monta_pagamento');
        Route::get('/orcamentos/fechar_projeto', [OrcamentoClienteController::class, 'fechar_projeto'])->name('cliente.orcamentos.fechar_projeto');

        Route::get('/projetos', [ProjetoClienteController::class, 'index'])->name('cliente.projetos');
        Route::get('/projetos/acessar/{id?}', [ProjetoClienteController::class, 'acessar'])->name('cliente.projetos.acessar');
        Route::get('/projetos/anexos/buscar', [ProjetoClienteController::class, 'buscar_anexo'])->name('cliente.projetos.anexos.buscar');
        Route::get('/projetos/anexos/fechar_anexo', [ProjetoClienteController::class, 'fechar_anexo'])->name('cliente.projetos.anexos.fechar_anexo');
        Route::post('/projetos/financeiro/enviar_comprovante', [ProjetoClienteController::class, 'enviar_comprovante'])->name('cliente.projetos.financeiro.enviar_comprovante');
        Route::post('/projetos/financeiro/enviar_comprovante_anexo', [ProjetoClienteController::class, 'enviar_comprovante_anexo'])->name('cliente.projetos.financeiro.enviar_comprovante_anexo');
    });
});

Route::get('/teste', function(){

});
