<?php
require_once APPPATH.'libraries/database/Connection.php';
class CaLogin_model extends MY_Model{
    public $id_ca_login;
    public $nr_ip;
    public $qtd_tentativa;
    public $dt_tentativa;
    public function setIdCaLogin($id_ca_login){
        $this->id_ca_login = $id_ca_login;
    }
    public function getIdCaLogin(){
        return $this->id_ca_login;
    }
    public function setNrIp($nr_ip){
        $this->nr_ip = $nr_ip;
    }
    public function getNrIp(){
        return $this->nr_ip;
    }
    public function setQtdTentativa($qtd_tentativa){
        $this->qtd_tentativa = $qtd_tentativa;
    }
    public function getQtdTentativa(){
        return $this->qtd_tentativa;
    }
    public function setDtTentativa($dt_tentativa){
        $this->dt_tentativa = $dt_tentativa;
    }
    public function getDtTentativa(){
        return $this->dt_tentativa;
    }

    public function __construct(){
        parent::__construct();
        $this->nomeTabela   = 'ca_login';
        $this->nomeModel    = 'CaLogin_model';
        $this->nomeIdTabela = 'id_ca_login';
    }
    public function inserir($obCaLogin){
        $con = Connection::getConn();
        $sql = ("INSERT INTO ".$this->nomeTabela." (nr_ip, qtd_tentativa, dt_tentativa) VALUES ('".$obCaLogin->nr_ip."', '".$obCaLogin->qtd_tentativa."', STR_TO_DATE('".$obCaLogin->dt_tentativa."','%Y-%m-%d %H:%i:%s'))");
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao inserir o ca_login!");
            return false;
        }
        $obCaLogin->setIdCaLogin($con->lastInsertId());
        parent::inserir($obCaLogin);
        return true;

    }

    public function alterar($obCaLogin, $objetoAntesAlteracao){
        $con = Connection::getConn();
        $sql = "UPDATE ".$this->nomeTabela." SET nr_ip = '".$obCaLogin->nr_ip."', qtd_tentativa = '".$obCaLogin->qtd_tentativa."',dt_tentativa = STR_TO_DATE('".$obCaLogin->dt_tentativa."','%Y-%m-%d %H:%i:%s') WHERE id_ca_login = '".$obCaLogin->id_ca_login."'";
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao alterar o produto!");
            return false;
        }
        parent::alterar($obCaLogin, $objetoAntesAlteracao);
        return true;

    }

}