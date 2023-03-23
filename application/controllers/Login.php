<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
    public function __construct(){
        parent::__construct();
        
        $this->load->model('usuarios_model');
        $this->load->model('calogin_model');
        $this->load->model('calogintrava_model');
        $this->load->model('perfis_model');

        $obPerfil = new Perfis_model();
        $this->dadosTemplates['arPerfis'] = $obPerfil->selecionaTodos();
        date_default_timezone_set("America/Sao_Paulo");
    }
	public function index()
	{
        $dados = $this->dadosTemplates;
		$dados['titulo'] = 'Login';        
		$this->load->view('login',$dados);
	}

    public function logar(){
        $ip      = $this->input->ip_address();
        $email   = $this->input->post("nmEmail");
        $senha   = md5($this->input->post("teSenha"));
        
        try {
            $obUsuarioModel = new Usuarios_model();
            $obUsuario = $obUsuarioModel->lerPorArrayAtributos(array("email"=>$email,"senha"=>$senha));
            if($email == $obUsuario->email && $senha == $obUsuario->senha){
                $this->session->set_userdata("logado",1);
                $this->session->set_userdata("usuarioLogado",serialize($obUsuario));
                redirect(base_url());
            }else{
                $obCaLogin = new CaLogin_model();
                $obCaLogin = $obCaLogin->lerPorArrayAtributos(array('nr_ip'=>$ip,"CAST(dt_tentativa AS DATE)"=>array("="=>"CAST(now() AS DATE)")));
                
                if($obCaLogin->id_ca_login){
                    $obCaLoginTrava = new CaLoginTrava_model();
                    $obCaLoginTrava = $obCaLoginTrava->lerPorArrayAtributos(array('id_ca_login'=>$obCaLogin->id_ca_login,"cast(now() as datetime)"=>array("between"=>array("cast(dt_bloqueio as datetime)","cast(dt_desbloqueio as datetime)"))));
                    if(isset($obCaLoginTrava->id_login_trava) && !empty($obCaLoginTrava->id_login_trava)){
                        $dados['erro'] = "Usuário bloqueado por diversas tentativas de login invalidas! Tente novamente.";
                        $this->load->view("login", $dados);
                    }else{
                        if($obCaLogin->qtd_tentativa >= 3){
                            $dtBloqueio = date('Y-m-d H:i:s');
                            $duracao = '00:30:00';
                            list($h, $m, $s) = explode(':', $duracao);
                            $dtDesbloqueio =  date('Y-m-d H:i:s', strtotime($dtBloqueio) + $s + ($m * 60) + ($h * 3600));
                            $obCaLoginTrava = new CaLoginTrava_model();
                            $obCaLoginTrava->setIdCaLogin($obCaLogin->id_ca_login);
                            $obCaLoginTrava->setDtBloqueio($dtBloqueio);                
                            $obCaLoginTrava->setDtDesbloqueio($dtDesbloqueio);
                            $obCaLoginTrava->inserir($obCaLoginTrava);
                            $dados['erro'] = "Usuário bloqueado por diversas tentativas de login invalidas! Tente novamente.";
                            $this->load->view("login", $dados);
                        }else{
                            $dtTentativa = date('Y-m-d H:i:s');
                            $obCaLoginAntesAlteracao = clone $obCaLogin;
                            $obCaLogin->setQtdTentativa(++$obCaLogin->qtd_tentativa);  
                            $obCaLogin->setDtTentativa($dtTentativa);  
                            $obCaLogin->alterar($obCaLogin,$obCaLoginAntesAlteracao);

                            $dados['erro'] = "Usuário/Senha incorretos! Tente novamente.";
                            $this->load->view("login", $dados);
                        }
                        
                    }
                }else{
                    $obCaLogin = new CaLogin_model();
                    $obCaLogin->setNrIp($ip);
                    $obCaLogin->setQtdTentativa(1);                
                    $obCaLogin->setDtTentativa(date('Y-m-d H:m:s'));
                    $obCaLogin->inserir($obCaLogin);
                            
                    $dados['erro'] = "Usuário/Senha incorretos! Tente novamente.";
                    $this->load->view("login", $dados);
                }
            }
        } catch (\Throwable $th) {
            $dados['erro'] = "Usuário/Senha incorretos! Tente novamente.";
            $this->load->view("login", $dados);
        }
        
    }
    public function cadastrar(){    
        $email     = $this->input->post("email");        
        $nome      = $this->input->post("nome");        
        $nrCgc     = $this->input->post("nrCgc");     
        $idPerfil  = $this->input->post("idPerfil");
        $senha     = md5($this->input->post("senha"));

        //try {
            $obUsuario = new Usuarios_model();
            $obUsuario->setNome($nome);
            $obUsuario->setNrCgc($nrCgc);
            $obUsuario->setCsPessoa(strlen($nrCgc) == 14 ? 'J' : 'F');
            $obUsuario->setSenha($senha);
            $obUsuario->setEmail($email);
            $obUsuario->setCsAtivo(1);
            $obUsuario->setIdPerfil($idPerfil);
            $boSucesso = $obUsuario->inserir($obUsuario);
            if($boSucesso){
                echo '<script>alert("Usuario inserido com sucesso!");</script>';
                echo '<script>location.href="'.base_url('index.php/login/').'";</script>';
            }

        //} catch (\Throwable $th) {
        //    $dados['erro'] = "Não foi possivel cadastrar usuário! Tente novamente mais tarde.";
        //    $this->load->view("login", $dados);
       // }
    }

    public function logout(){
        $this->session->unset_userdata("logado");
        redirect(base_url());
    }

}
