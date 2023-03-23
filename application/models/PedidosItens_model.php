<?php
require_once APPPATH.'libraries/database/Connection.php';
class PedidosItens_model extends MY_Model{
    public $id_pedido_item;
    public $id_pedido;
    public $id_produto;
    public $qt_item;
    public $vl_item;
    public function setIdPedidoItem($id_pedido_item){
        $this->id_pedido_item = $id_pedido_item;
    }
    public function getIdPedidoItem(){
        return $this->id_pedido_item;
    }
    public function setIdPedido($id_pedido){
        $this->id_pedido = $id_pedido;
    }
    public function getIdPedido(){
        return $this->id_pedido;
    }
    public function setIdProduto($id_produto){
        $this->id_produto = $id_produto;
    }
    public function getIdProduto(){
        return $this->id_produto;
    }
    public function setQtItem($qt_item){
        $this->qt_item = $qt_item;
    }
    public function getQtItem(){
        return $this->qt_item;
    }
    public function setVlItem($vl_item){
        $this->vl_item = $vl_item;
    }
    public function getVlItem(){
        return $this->vl_item;
    }

    public function __construct(){
        parent::__construct();
        $this->nomeTabela   = 'pedidos_itens';
        $this->nomeModel    = 'PedidosItens_model';
        $this->nomeIdTabela = 'id_pedido_item';
    }

    public function alterar($obPedidoItem, $obPedidoItemAntesAlteracao){
        $con = Connection::getConn();
        $sql = "UPDATE ".$this->nomeTabela." SET  id_pedido = '".$obPedido->id_pedido."', id_produto = '".$obPedido->id_produto."', qt_item = '".$obPedido->qt_item."',vl_item = '".$obPedido->vl_item."' WHERE id_pedido_item = '".$obPedido->id_pedido_item."'";
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao alterar o pedido item!");
            return false;
        }
        parent::alterar($obPedidoItem,$obPedidoItemAntesAlteracao);
        return true;

    }

    public function inserir($obPedidoItem){
        $con = Connection::getConn();
        $sql = ("INSERT INTO ".$this->nomeTabela." (id_pedido, id_produto, qt_item, vl_item) VALUES ('".$obPedidoItem->id_pedido."','".$obPedidoItem->id_produto."', '".$obPedidoItem->qt_item."', '".$obPedidoItem->vl_item."')");
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao inserir o pedido item!");
            return false;
        }
        $obPedidoItem->setIdPedidoItem($con->lastInsertId());
        parent::inserir($obPedidoItem);
        return true;

    }
    

}