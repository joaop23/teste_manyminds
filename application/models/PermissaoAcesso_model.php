<?php
require_once APPPATH.'libraries/database/Connection.php';
class Produtos_model extends MY_Model{
    public $id_permissao_acesso;
    public $cs_permissao;
    public $id_perfil;
    public $id_menu;
    public function setIdPermissaoAcesso($id_permissao_acesso){
        $this->id_permissao_acesso = $id_permissao_acesso;
    }
    public function getIdPermissaoAcesso(){
        return $this->id_permissao_acesso;
    }
    public function setCsPermissao($cs_permissao){
        $this->cs_permissao = $cs_permissao;
    }
    public function getCsPermissao(){
        return $this->cs_permissao;
    }
    public function setIdPerfil($id_perfil){
        $this->id_perfil = $id_perfil;
    }
    public function getIdPerfil(){
        return $this->id_perfil;
    }
    public function setIdMenu($id_menu){
        $this->id_menu = $id_menu;
    }
    public function getIdMenu(){
        return $this->id_menu;
    }

    public function __construct(){
        parent::__construct();
        $this->nomeTabela   = 'permissao_acesso';
        $this->nomeModel    = 'PermissaoAcesso_model';
        $this->nomeIdTabela = 'id_permissao_acesso';
    }
}