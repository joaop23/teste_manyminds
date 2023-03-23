<?php
require_once APPPATH.'libraries/database/Connection.php';
class Pedidos_model extends MY_Model{
    public $id_pedido;
    public $id_usuario;
    public $observacao;
    public $cs_status;
    public $vl_total;
    public $cd_pedido;
    public function setCdPedido($cd_pedido){
        $this->cd_pedido = $cd_pedido;
    }
    public function getCdPedido(){
        return $this->cd_pedido;
    }
    public function setIdPedido($id_pedido){
        $this->id_pedido = $id_pedido;
    }
    public function getIdPedido(){
        return $this->id_pedido;
    }
    public function setIdUsuario($id_usuario){
        $this->id_usuario = $id_usuario;
    }
    public function getIdUsuario(){
        return $this->id_usuario;
    }
    public function setObservacao($observacao){
        $this->observacao = $observacao;
    }
    public function getObservacao(){
        return $this->observacao;
    }
    public function setCsStatus($cs_status){
        $this->cs_status = $cs_status;
    }
    public function getCsStatus(){
        return $this->cs_status;
    }
    public function setVlTotal($vl_total){
        $this->vl_total = $vl_total;
    }
    public function getVlTotal(){
        return $this->vl_total;
    }

    public function __construct(){
        parent::__construct();
        $this->nomeTabela   = 'pedidos';
        $this->nomeModel    = 'Pedidos_model';
        $this->nomeIdTabela = 'id_pedido';
    }
    public function alterar($obPedido, $obPedidoAntesAlteracao){
        $con = Connection::getConn();
        $sql = "UPDATE ".$this->nomeTabela." SET cd_pedido = '".$obPedido->cd_pedido."', id_usuario = '".$obPedido->id_usuario."', observacao = '".$obPedido->observacao."',cs_status = '".$obPedido->cs_status."',vl_total = '".$obPedido->vl_total."' WHERE id_pedido = '".$obPedido->id_pedido."'";
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao alterar o usuario!");
            return false;
        }
        parent::alterar($obPedido, $obPedidoAntesAlteracao);
        return true;

    }

    public function inserir($obPedido){
        $con = Connection::getConn();
        $sql = ("INSERT INTO ".$this->nomeTabela." (cd_pedido, id_usuario, observacao, cs_status, vl_total) VALUES ('".$obPedido->cd_pedido."','".$obPedido->id_usuario."', '".$obPedido->observacao."', '".$obPedido->cs_status."','".$obPedido->vl_total."')");
        
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao inserir o pedido!");
            return false;
        }
        $obPedido->setIdPedido($con->lastInsertId());
        parent::inserir($obPedido);
        return true;

    }

    public function excluir($idPedido){
        parent::excluir($idPedido);
        $con = Connection::getConn();
        $sql = $con->prepare("DELETE FROM ".$this->nomeTabela." WHERE id_pedido='".$idPedido."'");
       
        $resultado = $sql->execute();
        if($resultado == 0){
            throw new Exception("Falha ao excluir o pedido!");
            return false;
        }
        return true;
    }
}