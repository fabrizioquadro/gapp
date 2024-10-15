<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\UsuarioEmpresa;

class LoginController extends Controller
{
    public function admin_index(){
        return view('login/index_admin');
    }

    public function admin_login(Request $request){
        $dados = $request->except('_token');
        if(Auth::attempt($dados)){
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }
        else{
            return redirect()->back()->with('mensagem_erro', "Email ou senha inválidos");
        }
    }

    public function admin_recuperar_senha(){
        return view('login/recuperar_senha_admin');
    }

    public function admin_gerar_nova_senha(Request $request){
        //vamos verificar se existe esse email
        $user = User::where('email', $request->get('email'))->first();
        if($user){
            $novaSenha = createPassword(8, true, true, true, false);
            $user->password = bcrypt($novaSenha);
            $user->save();

            $mensagem = "
            <h4>Nova Senha de Acesso ao Sistema Gapp Serviço Inteligente</h4>
            <p>
                Foi alterado por sua solicitação a senha de acesso ao sistema.
            </p>
            <p>
                Sua nova senha é: $novaSenha
            </p>
            ";

            enviarMail($user->email, 'Gapp Serviço Inteligente - Nova Senha de Acesso', $mensagem);

            return redirect()->route('admin.index')->with('mensagem_sucesso','Sua nova senha foi enviado para o seu email.');
        }
        else{
            return redirect()->back()->with('mensagem_erro', "Email inválido");
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.index');
    }

    public function empresa_index(){
        return view('login/index_empresa');
    }

    public function empresa_register(){
        return view('login/register_empresa');
    }

    public function empresa_register_insert(Request $request){
        //vamos testar se há uma empresa com esse email
        $ds_email = $request->get('ds_email');

        if(Empresa::where('ds_email', $ds_email)->count() > 0){
            return redirect()->route('empresa.register')->with('mensagem_erro', 'Já existe este email em nossa base de dados.');
        }

        $dados = $request->except('_token','password');
        $dados['ds_senha'] = md5($request->get('password'));
        $dados['st_empresa'] = 'Liberada';
        $dados['dt_validade'] = date('Y-m-d', strtotime("+30 days", strtotime(date('Y-m-d'))));;
        $empresa = Empresa::create($dados);

        if($request->hasFile('imagem') && $request->file('imagem')->isValid()){
            $imagem = $request->imagem;
            $extensao = $imagem->extension();

            $nmImagem = $empresa->id.".".$extensao;

            $request->imagem->move(public_path('/empresas/imagem'), $nmImagem);

            $empresa->imagem = $nmImagem;

            $empresa->save();
        }
        return redirect()->route('empresa.index')->with('mensagem_sucesso','Empresa Cadastrada! - Você já pode acessar o nosso sistema.');
    }

    public function empresa_recuperar_senha(){
        return view('login/recuperar_senha_empresa');
    }

    public function empresa_gerar_nova_senha(Request $request){
        //vamos verificar se há a empresa com o email
        $empresa = Empresa::where('ds_email', $request->get('email'))->first();

        if($empresa){
            $novaSenha = createPassword(8, true, true, true, false);
            $empresa->ds_senha = md5($novaSenha);
            $empresa->save();

            $mensagem = "
            <h4>Nova Senha de Acesso ao Sistema Gapp Serviço Inteligente</h4>
            <p>
                Foi alterado por sua solicitação a senha de acesso ao sistema.
            </p>
            <p>
                Sua nova senha é: $novaSenha
            </p>
            ";

            enviarMail($empresa->ds_email, 'Gapp Serviço Inteligente - Nova Senha de Acesso', $mensagem);

            return redirect()->route('empresa.index')->with('mensagem_sucesso','Sua nova senha foi enviado para o seu email.');
        }
        else{
            //vamos verificar se não é um email de um usuario de alguma empresa
            $usuario = UsuarioEmpresa::where('ds_email', $request->get('email'))->first();

            if($usuario){
                $novaSenha = createPassword(8, true, true, true, false);
                $usuario->ds_senha = md5($novaSenha);
                $usuario->save();

                $mensagem = "
                <h4>Nova Senha de Acesso ao Sistema Gapp Serviço Inteligente</h4>
                <p>
                    Foi alterado por sua solicitação a senha de acesso ao sistema.
                </p>
                <p>
                    Sua nova senha é: $novaSenha
                </p>
                ";

                enviarMail($usuario->ds_email, 'Gapp Serviço Inteligente - Nova Senha de Acesso', $mensagem);

                return redirect()->route('empresa.index')->with('mensagem_sucesso','Sua nova senha foi enviado para o seu email.');
            }
            else{
                return redirect()->route('empresa.recuperar_senha')->with('mensagem_erro','Email não estaligado a nenhuma empresa');
            }
        }

    }

    public function empresa_login(Request $request){
        $ds_email = $request->get('email');
        $empresa = Empresa::where('ds_email', $ds_email)->first();

        if(!$empresa){
            //vamos testar se há login de usuario de empresa
            $usuario = UsuarioEmpresa::where('ds_email', $request->get('email'))->first();
            if(!$usuario){
                return redirect()->route('empresa.index')->with('mensagem_erro','Este email não existe na nossa base de dados.');
            }

            $ds_senha = md5($request->get('password'));
            if($ds_senha == $usuario->ds_senha){
                $empresa = Empresa::where('id', $usuario->empresa_id)->first();
                $request->session()->put('empresa', $empresa);

                //como foi a empresa mesmo que fez o login, vamos salvar isso na sessao
                $dados_sessao = array();
                $dados_sessao['tipo_login'] = "usuario";

                $request->session()->put('login_sessao', $dados_sessao);
                $request->session()->put('usuario', $usuario);

                return redirect()->route('empresa.dashboard');
            }
            else{
                return redirect()->route('empresa.index')->with('mensagem_erro','Senha Inválida.');
            }
        }

        $ds_senha = md5($request->get('password'));
        if($ds_senha == $empresa->ds_senha){
            $request->session()->put('empresa', $empresa);
            //como foi a empresa mesmo que fez o login, vamos salvar isso na sessao
            $dados_sessao = array();
            $dados_sessao['tipo_login'] = "empresa";

            $request->session()->put('login_sessao', $dados_sessao);

            return redirect()->route('empresa.dashboard');
        }
        else{
            return redirect()->route('empresa.index')->with('mensagem_erro','Senha Inválida.');
        }
    }

    public function logout_empresa(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('empresa.index');
    }

    public function cliente_index(){
        return view('login/index_cliente');
    }

    public function cliente_recuperar_senha(){
        return view('login/recuperar_senha_cliente');
    }

    public function cliente_gerar_nova_senha(Request $request){
        //vamos verificar se há a empresa com o email
        $cliente = Cliente::where('ds_email', $request->get('email'))->first();

        if($cliente){
            $novaSenha = createPassword(8, true, true, true, false);
            $cliente->ds_senha = md5($novaSenha);
            $cliente->save();

            $mensagem = "
            <h4>Nova Senha de Acesso ao Sistema Gapp Serviço Inteligente</h4>
            <p>
                Foi alterado por sua solicitação a senha de acesso ao sistema.
            </p>
            <p>
                Sua nova senha é: $novaSenha
            </p>
            ";

            enviarMail($cliente->ds_email, 'Gapp Serviço Inteligente - Nova Senha de Acesso', $mensagem);

            return redirect()->route('cliente.index')->with('mensagem_sucesso','Sua nova senha foi enviado para o seu email.');
        }
        else{
            return redirect()->route('cliente.recuperar_senha')->with('mensagem_erro','Email inválido');
        }
    }

    public function cliente_login(Request $request){
        $ds_email = $request->get('email');
        $cliente = Cliente::where('ds_email', $ds_email)->first();

        if($cliente){
            $ds_senha = md5($request->get('password'));
            if($ds_senha == $cliente->ds_senha){
                $request->session()->put('cliente', $cliente);
                return redirect()->route('cliente.dashboard');
            }
            else{
                return redirect()->route('cliente.index')->with('mensagem_erro','Senha Inválida.');
            }
        }
        else{
            return redirect()->route('cliente.index')->with('mensagem_erro','Email Inválida.');
        }
    }

    public function logout_cliente(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('cliente.index');
    }
}
