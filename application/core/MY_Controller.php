<?php
    class MY_Controller extends CI_Controller{
        public $dadosTemplates = array();
        public function __construct(){
            parent::__construct();

            $logado = $this->session->userdata('logado');

            if($logado != 1){
                redirect(base_url('index.php/login'));
            }
            
		    $this->load->model('usuarios_model');
		    $this->load->model('menu_model');
		    $this->load->model('log_model');
		    $this->load->model('detalhelog_model');
            $obUsuario = unserialize($this->session->userdata('usuarioLogado'));
		    $this->dadosTemplates['nomeUsuario'] = $obUsuario->nome;
            $obMenu = new Menu_model();
            $arMenu = $obMenu->selecionaTodosMenu($obUsuario->id_usuario);
            $this->dadosTemplates['arMenu'] = $arMenu;            
        }

       
    }