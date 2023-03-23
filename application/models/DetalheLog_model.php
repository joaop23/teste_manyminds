<?php
require_once APPPATH.'libraries/database/Connection.php';
class DetalheLog_model extends MY_Model{
    public $id_detalhe_log;
    public $id_log;
    public $atributo;
    public $valor;
    public $valor_novo;
    public function setIdDetalheLog($id_detalhe_log){
        $this->id_detalhe_log = $id_detalhe_log;
    }
    public function getIdDetalheLog(){
        return $this->id_detalhe_log;
    }
    public function setIdLog($id_log){
        $this->id_log = $id_log;
    }
    public function getIdLog(){
        return $this->id_log;
    }
    public function setAtributo($atributo){
        $this->atributo = $atributo;
    }
    public function geAtributo(){
        return $this->atributo;
    }
    public function setValor($valor){
        $this->valor = $valor;
    }
    public function getValor(){
        return $this->valor;
    }
    public function setValorNovo($valor_novo){
        $this->valor_novo = $valor_novo;
    }
    public function getValorNovo(){
        return $this->valor_novo;
    }

    public function __construct(){
        $this->nomeTabela   = 'detalhe_log';
        $this->nomeModel    = 'Detalhe_model';
        $this->nomeIdTabela = 'id_detalhe_log';
    }

    public function inserir($obDetalheLog){
        $con = Connection::getConn();
        $sql = ("INSERT INTO ".$this->nomeTabela." (id_log, atributo, valor, valor_novo) VALUES ('".$obDetalheLog->id_log."', '".$obDetalheLog->atributo."', '".$obDetalheLog->valor."', '".$obDetalheLog->valor_novo."')");
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao inserir o detalhe log!");
            return false;
        }
        return true;

    }

}