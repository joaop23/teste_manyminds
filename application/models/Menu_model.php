<?php
require_once APPPATH.'libraries/database/Connection.php';
class Menu_model extends MY_Model{
    public $id_menu;
    public $nm_programa;
    public $icone;
    public $url;
    public function setIdMenu($id_menu){
        $this->id_menu = $id_menu;
    }
    public function getIdMenu(){
        return $this->id_menu;
    }
    public function setNmPrograma($nm_programa){
        $this->nm_programa = $nm_programa;
    }
    public function getNmPrograma(){
        return $this->nm_programa;
    }
    public function setIcone($icone){
        $this->icone = $icone;
    }
    public function getIcone(){
        return $this->icone;
    }
    public function setUrl($url){
        $this->url = $url;
    }
    public function getUrl(){
        return $this->url;
    }

    public function __construct(){
        parent::__construct();
        $this->nomeTabela   = 'menu';
        $this->nomeModel    = 'Menu_model';
        $this->nomeIdTabela = 'id_menu';
    }

    public function selecionaTodosMenu($idUsuario){
        $con = Connection::getConn();
        $sql = "SELECT * FROM ".$this->nomeTabela." M, permissao_acesso p, perfis pf, usuarios u WHERE m.id_menu=p.id_menu and pf.id_perfil=p.id_perfil and p.cs_permissao=1 and p.id_perfil = u.id_perfil";
        $sql = $con->prepare($sql);
        $sql->execute();
        
        $resultado = array();
        while($row = $sql->fetchObject('Menu_model')){
            $resultado[] = $row;
        }

        return $resultado;
    }
}