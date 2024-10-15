<!DOCTYPE html>
<html lang="pt-BR" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('/public/template') }}/" data-template="vertical-menu-template">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <title>Gapp Serviço Inteligente - Sistema Online</title>
        <meta name="description" content="Gapp Serviço Inteligente" />
        <link rel="icon" type="image/x-icon" href="{{ asset('/public/img/favicon.png') }}" />
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />
        <!-- Icons -->
        <link rel="stylesheet" href="{{ asset('/public/template/vendor/fonts/materialdesignicons.css') }}" />
        <link rel="stylesheet" href="{{ asset('/public/template/vendor/fonts/flag-icons.css') }}" />
        <!-- Menu waves for no-customizer fix -->
        <link rel="stylesheet" href="{{ asset('/public/template/vendor/libs/node-waves/node-waves.css') }}" />
        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('/public/template/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('/public/template/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('/public/template/css/demo.css') }}" />
        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('/public/template/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('/public/template/vendor/libs/typeahead-js/typeahead.css') }}" />
        <!-- Vendor -->
        <link rel="stylesheet" href="{{ asset('/public/template/vendor/libs/bs-stepper/bs-stepper.css') }}" />
        <link rel="stylesheet" href="{{ asset('/public/template/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
        <link rel="stylesheet" href="{{ asset('/public/template/vendor/libs/select2/select2.css') }}" />
        <link rel="stylesheet" href="{{ asset('/public/template/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
        <!-- Page CSS -->
        <!-- Page -->
        <link rel="stylesheet" href="{{ asset('/public/template/vendor/css/pages/page-auth.css') }}" />
        <!-- Helpers -->
        <script src="{{ asset('/public/template/vendor/js/helpers.js') }}"></script>
        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        <script src="{{ asset('/public/template/vendor/js/template-customizer.js') }}"></script>
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ asset('/public/template/js/config.js') }}"></script>
    </head>

    <body>
        <!-- Content -->
        <div class="authentication-wrapper authentication-cover">
            <!-- Logo -->
            <a href="#" class="auth-cover-brand d-flex align-items-center gap-2">
                <img src="{{ asset('/public/img/logo.png') }}" style="max-height: 50px" alt="Logo">
            </a>
            <!-- /Logo -->
            <div class="authentication-inner row m-0">
                <!-- Left Text -->
                <div class="d-none d-lg-flex col-lg-4 align-items-center justify-content-center p-5 mt-5 mt-xxl-0">
                    <img alt="register-multi-steps-illustration" src="{{ asset('/public/template/img/illustrations/auth-register-multi-steps-illustration.png') }}" class="h-auto mh-100 w-px-200" />
                </div>
                <!-- /Left Text -->

                <!--  Multi Steps Registration -->
                <div class="d-flex col-lg-8 align-items-center justify-content-center authentication-bg p-5">
                    <div class="w-px-700 mt-5 mt-lg-0">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Cadastro</h5>
                                <p>Bem vindo a <b>Gapp Sistema Inteligente</b>, faça seu cadastro, é fácil, rápido e você poderá acessar nosso sistema para teste.</p>
                                @if($mensagem = Session::get('mensagem_erro'))
                                    <div class="alert alert-danger alert-dismissible mt-3" role="alert">
                                        {{ $mensagem }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <form action="{{ route('empresa.register.insert') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-1 gy-4">
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-outline">
                                                <input required class="form-control" type="text" id="nome" name="nm_empresa" placeholder="Nome:"/>
                                                <label for="nome">Nome:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-outline">
                                                <input required class="form-control" type="email" id="email" name="ds_email" placeholder="john.doe@example.com" />
                                                <label for="email">E-mail:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-outline">
                                                <select id="tp_empresa" name='tp_empresa' class="form-select">
                                                    <option value=""></option>
                                                    <option value="Pessoa Física">Pessoa Física</option>
                                                    <option value="Pessoa Jurídica">Pessoa Jurídica</option>
                                                </select>
                                                <label for="tp_empresa">Pessoa:</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1 gy-4">
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="text" id="nr_cnpj" name="nr_cnpj" placeholder="CNPJ/CPF:"/>
                                                <label for="nr_cnpj">CNPJ/CPF:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="text" id="tel" name="nr_tel" placeholder="Telefone:" maxlength="15" onkeypress="mascara( this, mtel )" />
                                                <label for="tel">Telefone:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="text" id="cel" name="nr_cel" placeholder="Celular:" maxlength="15" onkeypress="mascara( this, mtel )" />
                                                <label for="cel">Celular:</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1 gy-4">
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="text" id="endereco" name="ds_endereco" placeholder="Endereço:"/>
                                                <label for="endereco">Endereço:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="text" id="numero" name="nr_endereco" placeholder="Número:" />
                                                <label for="numero">Número:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="text" id="complemento" name="ds_complemento" placeholder="Complemento:" />
                                                <label for="complemento">Complemento:</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1 gy-4">
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="text" id="bairro" name="ds_bairro" placeholder="Bairro:"/>
                                                <label for="bairro">Bairro:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="text" id="cidade" name="nm_cidade" placeholder="Cidade:" />
                                                <label for="cidade">Cidade:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="text" id="uf" name="ds_uf" placeholder="UF:" />
                                                <label for="uf">UF:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="text" id="cep" name="nr_cep" placeholder="CEP:"  maxlength="9" onkeypress="formatar('#####-###', this)" />
                                                <label for="cep">CEP:</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1 gy-4">
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-outline">
                                                <input required class="form-control" type="password" id="password" name="password" placeholder="********" />
                                                <label for="password">Senha:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="file" id="imagem" name="imagem"/>
                                                <label for="imagem">Logo:</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-secondary me-2">Salvar</button>
                                    </div>
                                </form>
                                <p class="text-center">
                                    <span>Já tem uma conta?</span>
                                    <a href="{{ route('empresa.index') }}">
                                        <span>Acesse aqui</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Multi Steps Registration -->
            </div>
        </div>
        <!-- / Content -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->

        <script>
      // Check selected custom option
      window.Helpers.initCustomOptionCheck();
    </script>

        <script src="{{ asset('/public/template/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/libs/node-waves/node-waves.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/libs/hammer/hammer.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/libs/i18n/i18n.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/libs/typeahead-js/typeahead.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/js/menu.js') }}"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{ asset('/public/template/vendor/libs/cleavejs/cleave.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/libs/select2/select2.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
        <script src="{{ asset('/public/template/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('/public/template/js/main.js') }}"></script>

        <!-- Page JS -->
        <script src="{{ asset('/public/template/js/pages-auth-multisteps.js') }}"></script>
        <script src="{{ asset('/public/js/script.js') }}"></script>
        <script>
        document.getElementById('tp_empresa').addEventListener('change', (e)=>{
            if(e.target.value == "Pessoa Física"){
                document.getElementById('nr_cnpj').setAttribute('maxlength', '14');
                document.getElementById('nr_cnpj').setAttribute('onkeypress', "formatar('###.###.###-##', this)");
            }
            else if(e.target.value == "Pessoa Jurídica"){
                document.getElementById('nr_cnpj').setAttribute('maxlength', '18');
                document.getElementById('nr_cnpj').setAttribute('onkeypress', "formatar('##.###.###/####-##', this)");
            }
            else{
                document.getElementById('nr_cnpj').removeAttribute('maxlength');
                document.getElementById('nr_cnpj').removeAttribute('onkeypress');
            }
        })
        </script>
    </body>
</html>
