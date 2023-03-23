<?php
require_once APPPATH.'libraries/database/Connection.php';
class CaLoginTrava_model extends MY_Model{
    public $id_ca_login_trava;
    public $dt_bloqueio;
    public $dt_desbloqueio;
    public $id_ca_login;
    public function setIdCaLoginTrava($id_ca_login_trava){
        $this->id_ca_login_trava = $id_ca_login_trava;
    }
    public function getIdCaLoginTrava(){
        return $this->id_ca_login_trava;
    }
    public function setDtBloqueio($dt_bloqueio){
        $this->dt_bloqueio = $dt_bloqueio;
    }
    public function getDtBloqueio(){
        return $this->dt_bloqueio;
    }
    public function setDtDesbloqueio($dt_desbloqueio){
        $this->dt_desbloqueio = $dt_desbloqueio;
    }
    public function getDtDesbloqueio(){
        return $this->dt_desbloqueio;
    }
    public function setIdCaLogin($id_ca_login){
        $this->id_ca_login = $id_ca_login;
    }
    public function getIdCaLogin(){
        return $this->id_ca_login;
    }

    public function __construct(){
        parent::__construct();
        $this->nomeTabela   = 'ca_login_trava';
        $this->nomeModel    = 'CaLoginTrava_model';
        $this->nomeIdTabela = 'id_ca_login_trava';
    }

   
    
    public  function inserir($obCaLoginTrava){
        $con = Connection::getConn();
        $sql = ("INSERT INTO ".$this->nomeTabela." (dt_bloqueio, dt_desbloqueio, id_ca_login) VALUES (cast('".$obCaLoginTrava->dt_bloqueio."' AS DATETIME),cast('".$obCaLoginTrava->dt_desbloqueio."' AS DATETIME), '".$obCaLoginTrava->id_ca_login."')");
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao inserir o ca_login_trava!");
            return false;
        }
        $obCaLoginTrava->setIdCaLoginTrava($con->lastInsertId());
        parent::inserir($obCaLoginTrava);
        return true;

    }

}