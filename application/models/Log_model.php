<?php
require_once APPPATH.'libraries/database/Connection.php';
class Log_model extends MY_Model{
    public $id_log;
    public $dt_alteracao;
    public $tabela;
    public $id_alterado;
    public $operacao;    
    public $nr_ip;  
    public $id_usuario;
    public function setIdLog($id_log){
        $this->id_log = $id_log;
    }
    public function getIdLog(){
        return $this->id_log;
    }
    public function setDtAlteracao($dt_alteracao){
        $this->dt_alteracao = $dt_alteracao;
    }
    public function getDtAlteracao(){
        return $this->dt_alteracao;
    }
    public function setTabela($tabela){
        $this->tabela = $tabela;
    }
    public function getTabela(){
        return $this->tabela;
    }
    public function setIdAlterado($id_alterado){
        $this->id_alterado = $id_alterado;
    }
    public function getIdAlterado(){
        return $this->id_alterado;
    }
    public function setOperacao($operacao){
        $this->operacao = $operacao;
    }
    public function getOperacao(){
        return $this->operacao;
    }
    public function setNrIp($nr_ip){
        $this->nr_ip = $nr_ip;
    }
    public function getNrIp(){
        return $this->nr_ip;
    }
    public function setIdUsuario($id_usuario){
        $this->id_usuario = $id_usuario;
    }
    public function getIdUsuario(){
        return $this->id_usuario;
    }

    public function __construct(){
        parent::__construct();
        $this->nomeTabela   = 'log';
        $this->nomeModel    = 'Log_model';
        $this->nomeIdTabela = 'id_log';
    }
    public function inserir($obLog){
        $con = Connection::getConn();
        $sql = ("INSERT INTO ".$this->nomeTabela." (dt_alteracao, tabela, id_alterado, operacao, nr_ip, id_usuario) VALUES ('".$obLog->dt_alteracao."', '".$obLog->tabela."', '".$obLog->id_alterado."', '".$obLog->operacao."', '".$obLog->nr_ip."', '".$obLog->id_usuario."')");
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao inserir o log!");
            return false;
        }
        $obLog->setIdLog($con->lastInsertId());
        
        return true;

    }

}