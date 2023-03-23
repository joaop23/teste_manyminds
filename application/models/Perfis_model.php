<?php
require_once APPPATH.'libraries/database/Connection.php';
class Perfis_model extends MY_Model{
    public $id_perfil;
    public $nm_perfil;
    public $id_usuario;
    public $cs_perfil;
    public function setIdPerfil($id_perfil){
        $this->id_perfil = $id_perfil;
    }
    public function getIdPerfil(){
        return $this->id_perfil;
    }
    public function setNmPerfil($nm_perfil){
        $this->nm_perfil = $nm_perfil;
    }
    public function getNmPerfil(){
        return $this->nm_perfil;
    }
    public function setIdUsuario($id_usuario){
        $this->id_usuario = $id_usuario;
    }
    public function getIdUsuario(){
        return $this->id_usuario;
    }
    public function setCsPerfil($cs_perfil){
        $this->cs_perfil = $cs_perfil;
    }
    public function getCsPerfil(){
        return $this->cs_perfil;
    }

    public function __construct(){
        parent::__construct();
        $this->nomeTabela   = 'perfis';
        $this->nomeModel    = 'Perfis_model';
        $this->nomeIdTabela = 'id_perfil';
    }
}