<?php
require_once APPPATH.'libraries/database/Connection.php';
class Enderecos_model extends MY_Model{
    public $id_endereco;
    public $logradouro;
    public $numero;
    public $complemento;
    public $nm_bairro;
    public $nm_cidade;
    public $nr_cep;
    public $id_usuario;
    public function setIdEndereco($id_endereco){
        $this->id_endereco = $id_endereco;
    }
    public function getIdEndereco(){
        return $this->id_endereco;
    }
    public function setLogradouro($logradouro){
        $this->logradouro = $logradouro;
    }
    public function getLogradouro(){
        return $this->logradouro;
    }
    public function setNumero($numero){
        $this->numero = $numero;
    }
    public function getNumero(){
        return $this->numero;
    }
    public function setComplemento($complemento){
        $this->complemento = $complemento;
    }
    public function getComplemento(){
        return $this->complemento;
    }
    public function setNmBairro($nm_bairro){
        $this->nm_bairro = $nm_bairro;
    }
    public function getNmBairro(){
        return $this->nm_bairro;
    }
    public function setNmCidade($nm_cidade){
        $this->nm_cidade = $nm_cidade;
    }
    public function getNmCidade(){
        return $this->nm_cidade;
    }
    public function setNrCep($nr_cep){
        $this->nr_cep = $nr_cep;
    }
    public function getNrCep(){
        return $this->nr_cep;
    }
    public function setIdUsuario($id_usuario){
        $this->id_usuario = $id_usuario;
    }
    public function getIdUsuario(){
        return $this->id_usuario;
    }

    public function __construct(){
        parent::__construct();
        
        $this->nomeTabela   = 'enderecos';
        $this->nomeModel    = 'Enderecos_model';
        $this->nomeIdTabela = 'id_endereco';
    }
    public function inserir($obEnderecoUsuario){
        $con = Connection::getConn();
        $sql = ("INSERT INTO ".$this->nomeTabela." (logradouro, numero, complemento, nm_bairro, nm_cidade, nr_cep, id_usuario) VALUES ('".$obEnderecoUsuario->logradouro."', '".$obEnderecoUsuario->numero."', '".$obEnderecoUsuario->complemento."', '".$obEnderecoUsuario->nm_bairro."', '".$obEnderecoUsuario->nm_cidade."', '".$obEnderecoUsuario->nr_cep."', '".$obEnderecoUsuario->id_usuario."')");
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao inserir o endereço!");
            return false;
        }
        $obEnderecoUsuario->setIdEndereco($con->lastInsertId());
        parent::inserir($obEnderecoUsuario);
        return true;

    }
}