<?php
require_once APPPATH.'libraries/database/Connection.php';
class Produtos_model extends MY_Model{
    public $id_produto;
    public $cs_ativo;
    public $cd_produto;
    public $nm_produto;
    public function setIdProduto($id_produto){
        $this->id_produto = $id_produto;
    }
    public function getIdProduto(){
        return $this->id_produto;
    }
    public function setCsAtivo($cs_ativo){
        $this->cs_ativo = $cs_ativo;
    }
    public function getCsAtivo(){
        return $this->cs_ativo;
    }
    public function setNmProduto($nm_produto){
        $this->nm_produto = $nm_produto;
    }
    public function getNmProduto(){
        return $this->nm_produto;
    }
    public function setCdProduto($cd_produto){
        $this->cd_produto = $cd_produto;
    }
    public function getCdProduto(){
        return $this->cd_produto;
    }

    public function __construct(){
        parent::__construct();
        $this->nomeTabela   = 'produtos';
        $this->nomeModel    = 'Produtos_model';
        $this->nomeIdTabela = 'id_produto';
    }
    public function ativarOuDesativarProduto($idProduto, $csAtivo){
        $con = Connection::getConn();
        $sql = $con->prepare("UPDATE ".$this->nomeTabela." SET cs_ativo = ".$csAtivo." WHERE id_produto='".$idProduto."'");
       
        $resultado = $sql->execute();
        if($resultado == 0){
            throw new Exception("Falha ao ativar/desativar o produto!");
            return false;
        }
        return true;
    }
    

    public function alterar($obProduto, $obProdutoAntesAlteracao){
        $con = Connection::getConn();
        $sql = "UPDATE ".$this->nomeTabela." SET nm_produto = '".$obProduto->nm_produto."', cd_produto = '".$obProduto->cd_produto."',cs_ativo = '".$obProduto->cs_ativo."' WHERE id_produto = '".$obProduto->id_produto."'";
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao alterar o produto!");
            return false;
        }
        
        parent::alterar($obProduto, $obProdutoAntesAlteracao);
        return true;

    }

    public function inserir($obProduto){
        $con = Connection::getConn();
        $sql = ("INSERT INTO ".$this->nomeTabela." (nm_produto, cd_produto, cs_ativo) VALUES ('".$obProduto->nm_produto."', '".$obProduto->cd_produto."', '".$obProduto->cs_ativo."')");
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao inserir o produto!");
            return false;
        }
        $obProduto->setIdProduto($con->lastInsertId());
        parent::inserir($obProduto);
        return true;

    }

}