<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller {

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
        $this->load->model('enderecos_model');
        $this->load->model('perfis_model');

        $this->dadosTemplates['titulo'] = 'Cadastro de Usuários';
        $obPerfil = new Perfis_model();
        $this->dadosTemplates['arPerfis'] = $obPerfil->selecionaTodos();
    }
	public function index()
	{      
        $dados = $this->dadosTemplates;
        $obUsuario = new Usuarios_model();
        $colecaoUsuarios = $obUsuario->selecionaTodos();
        $dados['coUsuarios'] = $colecaoUsuarios;
		$this->load->view('usuarios', $dados);
	}

    public function desativar(){
        $idUsuario = $this->input->get("id_usuario");   
        try {
            $obUsuario = new Usuarios_model();
            $sucesso = $obUsuario->ativarOuDesativarUsuario($idUsuario,0);
            if($sucesso){
                echo '<script>alert("Usuario Desativado com sucesso!");</script>';
                echo '<script>location.href="'.base_url('index.php/usuarios/').'";</script>';
            }
        } catch (\Throwable $th) {
            $dados['erro'] = "Não foi possivel desativar usuário! Tente novamente mais tarde.";
            $this->load->view("usuarios");
        }
    }

    public function ativar(){
        $idUsuario = $this->input->get("id_usuario"); 
        try {
            $obUsuario = new Usuarios_model();
            $sucesso = $obUsuario->ativarOuDesativarUsuario($idUsuario,1);
            if($sucesso){
                echo '<script>alert("Usuario Ativado com sucesso!");</script>';
                echo '<script>location.href="'.base_url('index.php/usuarios/').'";</script>';
            }
        } catch (\Throwable $th) {
            $dados['erro'] = "Não foi possivel ativar usuário! Tente novamente mais tarde.";
            $this->load->view("usuarios");
        }
    }
    
    public function verAlterar(){ 
        $idUsuario   = $this->input->get("id"); 
        //try{
            $dados = $this->dadosTemplates;
            $obUsuario = new Usuarios_model();
            $obUsuario = $obUsuario->lerPorId($idUsuario);
            $dados['obUsuario'] = $obUsuario;
            $dados['idUsuario'] = $idUsuario;
            $dados['idPerfil'] = $obUsuario->id_perfil;
            $obEndereco = new Enderecos_model(); 
            $coEnderecosUsuarios = $obEndereco->lerTodosPorArrayAtributos(array('id_usuario'=>$idUsuario));
            $dados['coEnderecosUsuarios'] = $coEnderecosUsuarios;
            $coEnderecosUsuarios = $this->session->set_userdata('coEnderecosUsuarios',serialize($coEnderecosUsuarios));
		    $this->load->view('usuarios_verAlterar', $dados);
       // }catch (\Throwable $th) {
        //    $dados['erro'] = "Não foi possivel entrar na alteração desse usuário! Tente novamente mais tarde.";
        //    $this->load->view("usuarios");
        //}
    }

    public function verInserir(){ 
        try{
            $dados = $this->dadosTemplates;
            $coEnderecosUsuarios = array();
            $dados['coEnderecosUsuarios'] = $coEnderecosUsuarios;
		    $this->load->view('usuarios_verInserir', $dados);
        }catch (\Throwable $th) {
            $dados['erro'] = "Não foi possivel entrar na alteração desse usuário! Tente novamente mais tarde.";
            $this->load->view("usuarios");
        }
    }

    public function alterar(){
        $idUsuario   = $this->input->post("idUsuario"); 
        $nome        = $this->input->post("nome"); 
        $email       = $this->input->post("email"); 
        $senha       = md5($this->input->post("senha"));
        $nr_cgc      = $this->input->post("nr_cgc"); 
        $idPerfil   = $this->input->post("idPerfil"); 
      //  try {
            $obUsuario = new Usuarios_model();
            $obUsuario = $obUsuario->lerPorId($idUsuario);
            $obUsuarioAntes = clone $obUsuario;
            $obUsuario->setNome($nome);
            $obUsuario->setEmail($email);
            $obUsuario->setSenha($senha);
            $obUsuario->setNrCgc($nr_cgc);
            $obUsuario->setIdPerfil($idPerfil);
            $obUsuario->setCsAtivo(1);
            $obUsuario->setCsPessoa(strlen($nr_cgc)==11 ? 'F' : 'J');
            $obUsuario->alterar($obUsuario, $obUsuarioAntes);

            $obEndereco = new Enderecos_model();
            $obEndereco->excluirTodosPorArrayAtributos(array('id_usuario'=>$idUsuario));

            $coEnderecosUsuarios = $this->session->userdata('coEnderecosUsuarios');
            $coEnderecosUsuarios = !empty($coEnderecosUsuarios) ? unserialize($coEnderecosUsuarios) : array();
            if(count($coEnderecosUsuarios)){
                foreach($coEnderecosUsuarios as $obEnderecoUsuario){
                    $obEnderecoUsuario->setIdUsuario($obUsuario->getIdUsuario());
                    $obEnderecoUsuario->inserir($obEnderecoUsuario);
                }
            }

            echo '<script>alert("Usuário alterado com sucesso!");</script>';
            echo '<script>location.href="'.base_url('index.php/usuarios/').'";</script>';
        //} catch (Exception $e) {
       //     $dados['erro'] = "Não foi possivel alterar o usuário! Tente novamente mais tarde.";
        //    $this->load->view("usuarios");
       // }
    }

    public function inserir(){
        $idUsuario   = $this->input->post("idUsuario"); 
        $nome        = $this->input->post("nome"); 
        $email       = $this->input->post("email"); 
        $senha       = $this->input->post("senha");
        $nr_cgc      = $this->input->post("nr_cgc"); 
        $idPerfil   = $this->input->post("idPerfil"); 

        try {
            
            $obUsuario = new Usuarios_model();
            $obUsuario->setNome($nome);
            $obUsuario->setEmail($email);
            $obUsuario->setSenha($senha);
            $obUsuario->setNrCgc($nr_cgc);
            $obUsuario->setIdPerfil($idPerfil);
            $obUsuario->setCsAtivo(1);
            $obUsuario->setCsPessoa(strlen($nr_cgc)==11 ? 'F' : 'J');
            $obUsuario->inserir($obUsuario);

            $coEnderecosUsuarios = $this->session->userdata('coEnderecosUsuarios');
            $coEnderecosUsuarios = !empty($coEnderecosUsuarios) ? unserialize($coEnderecosUsuarios) : array();
            if(count($coEnderecosUsuarios)){
                foreach($coEnderecosUsuarios as $obEnderecoUsuario){
                    $obEnderecoUsuario->setIdUsuario($obUsuario->getIdUsuario());
                    $obEnderecoUsuario->inserir($obEnderecoUsuario);
                }
            }

            echo '<script>alert("Usuário inserido com sucesso!");</script>';
            echo '<script>location.href="'.base_url('index.php/usuarios/').'";</script>';
        } catch (Exception $e) {
            $dados['erro'] = "Não foi possivel alterar o usuário! Tente novamente mais tarde.";
            $this->load->view("usuarios");
        }
    }

    public function incluirEndereco(){
        $logradouro = $this->input->post("logradouro"); 
        $numero     = $this->input->post("numero"); 
        $complemento= $this->input->post("complemento"); 
        $bairro     = $this->input->post("bairro"); 
        $cidade     = $this->input->post("cidade"); 
        $nrCep      = $this->input->post("nrCep"); 

        
        $coEnderecosUsuarios = $this->session->userdata('coEnderecosUsuarios');
        $coEnderecosUsuarios = !empty($coEnderecosUsuarios) ? unserialize($coEnderecosUsuarios) : array();
        $obEnderecoUsuario = new Enderecos_model();
        $obEnderecoUsuario->setLogradouro($logradouro);
        $obEnderecoUsuario->setNumero($numero);
        $obEnderecoUsuario->setComplemento($complemento);
        $obEnderecoUsuario->setNmBairro($bairro);
        $obEnderecoUsuario->setNmCidade($cidade);
        $obEnderecoUsuario->setNrCep(str_replace("-","",$nrCep));
        
        $coEnderecosUsuarios[] = $obEnderecoUsuario;
        $this->session->set_userdata('coEnderecosUsuarios', serialize($coEnderecosUsuarios));
        $dados['coEnderecosUsuarios'] = $coEnderecosUsuarios;
        echo json_encode(array('lista'=>$this->load->view('usuarios_enderecos', $dados, true)));
        die();
        
    }

    public function listarEnderecos($coEnderecosUsuarios){
        $obUsuario = new Usuarios_model();
        $colecaoUsuarios = $obUsuario->selecionaTodos();
    }

    public function excluirEndereco(){
        $indice = $this->input->post("indice"); 
        
        $coEnderecosUsuarios = $this->session->userdata('coEnderecosUsuarios');
        $coEnderecosUsuarios = !empty($coEnderecosUsuarios) ? unserialize($coEnderecosUsuarios) : array();
        unset($coEnderecosUsuarios[$indice]);

        $this->session->set_userdata('coEnderecosUsuarios', serialize($coEnderecosUsuarios));
        $dados['coEnderecosUsuarios'] = $coEnderecosUsuarios;
        echo json_encode(array('lista'=>$this->load->view('usuarios_enderecos', $dados, true)));
        die();        
    }

    function carregarEndereco(){
        $indice = $this->input->post("indice"); 
        
        $coEnderecosUsuarios = $this->session->userdata('coEnderecosUsuarios');
        $coEnderecosUsuarios = !empty($coEnderecosUsuarios) ? unserialize($coEnderecosUsuarios) : array();
        $obEnderecoUsuario = $coEnderecosUsuarios[$indice];

        echo json_encode(array('indice'=>$indice,
                               'logradouro'=>$obEnderecoUsuario->logradouro,
                               'numero'=>$obEnderecoUsuario->numero,
                               'complemento'=>$obEnderecoUsuario->complemento,
                               'bairro'=>$obEnderecoUsuario->nm_bairro,
                               'cidade'=>$obEnderecoUsuario->nm_cidade,
                               'nrCep'=>$obEnderecoUsuario->nr_cep));
        die();

    }

    function alterarEndereco(){
        $logradouro = $this->input->post("logradouro"); 
        $numero     = $this->input->post("numero"); 
        $complemento= $this->input->post("complemento"); 
        $bairro     = $this->input->post("bairro"); 
        $cidade     = $this->input->post("cidade"); 
        $nrCep      = $this->input->post("nrCep"); 
        $indice = $this->input->post("indice"); 
        $coEnderecosUsuarios = $this->session->userdata('coEnderecosUsuarios');
        $coEnderecosUsuarios = !empty($coEnderecosUsuarios) ? unserialize($coEnderecosUsuarios) : array();

        $obEnderecoUsuario = new Enderecos_model();
        $obEnderecoUsuario->setLogradouro($logradouro);
        $obEnderecoUsuario->setNumero($numero);
        $obEnderecoUsuario->setComplemento($complemento);
        $obEnderecoUsuario->setNmBairro($bairro);
        $obEnderecoUsuario->setNmCidade($cidade);
        $obEnderecoUsuario->setNrCep(str_replace("-","",$nrCep));
        
        $coEnderecosUsuarios[$indice] = $obEnderecoUsuario;
        $this->session->set_userdata('coEnderecosUsuarios', serialize($coEnderecosUsuarios));
        $dados['coEnderecosUsuarios'] = $coEnderecosUsuarios;
        echo json_encode(array('lista'=>$this->load->view('usuarios_enderecos', $dados, true)));
        die();
    }
}
