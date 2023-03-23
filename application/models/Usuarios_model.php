<?php
require_once APPPATH.'libraries/database/Connection.php';
class Usuarios_model extends MY_Model{
    public $id_usuario;
    public $cs_ativo;
    public $nome;
    public $senha;
    public $email;
    public $nr_cgc;
    public $cs_pessoa;
    public $id_perfil;
    public function setIdUsuario($id_usuario){
        $this->id_usuario = $id_usuario;
    }
    public function getIdUsuario(){
        return $this->id_usuario;
    }
    public function setCsAtivo($cs_ativo){
        $this->cs_ativo = $cs_ativo;
    }
    public function getCsAtivo(){
        return $this->cs_ativo;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getNome(){
        return $this->nome;
    }
    public function setSenha($senha){
        $this->senha = $senha;
    }
    public function getSenha(){
        return $this->senha;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setNrCgc($nr_cgc){
        $this->nr_cgc = $nr_cgc;
    }
    public function getNrCgc(){
        return $this->nr_cgc;
    }
    public function setCsPessoa($cs_pessoa){
        $this->cs_pessoa = $cs_pessoa;
    }
    public function getCsPessoa(){
        return $this->cs_pessoa;
    }
    public function setIdPerfil($id_perfil){
        $this->id_perfil = $id_perfil;
    }
    public function getIdPerfil(){
        return $this->id_perfil;
    }


    public function __construct(){
        parent::__construct();
        $this->nomeTabela   = 'usuarios';
        $this->nomeModel    = 'Usuarios_model';
        $this->nomeIdTabela = 'id_usuario';
    }
    public function ativarOuDesativarUsuario($idUsuario, $csAtivo){
        $con = Connection::getConn();
        $sql = $con->prepare("UPDATE ".$this->nomeTabela." SET cs_ativo = ".$csAtivo." WHERE id_usuario='".$idUsuario."'");
       
        $resultado = $sql->execute();
        if($resultado == 0){
            throw new Exception("Falha ao inserir o usuário!");
            return false;
        }
        return true;
    }
    

    public function alterar($obUsuario, $obUsuarioAntesAlteracao){
        $con = Connection::getConn();
        $sql = "UPDATE ".$this->nomeTabela." SET nome = '".$obUsuario->nome."', senha = '".$obUsuario->senha."',email = '".$obUsuario->email."',nr_cgc = '".$obUsuario->nr_cgc."',cs_pessoa = '".$obUsuario->cs_pessoa."',cs_ativo = '".$obUsuario->cs_ativo."',id_perfil = '".$obUsuario->id_perfil."' WHERE id_usuario = '".$obUsuario->id_usuario."'";
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao alterar o usuario!");
            return false;
        }
        parent::alterar($obUsuario, $obUsuarioAntesAlteracao);
        return true;

    }

    public function inserir($obUsuario){
        $con = Connection::getConn();
        $sql = ("INSERT INTO ".$this->nomeTabela." (nome, senha, email, nr_cgc, cs_pessoa, cs_ativo, id_perfil) VALUES ('".$obUsuario->nome."', '".$obUsuario->senha."','".$obUsuario->email."', '".$obUsuario->nr_cgc."', '".$obUsuario->cs_pessoa."', '".$obUsuario->cs_ativo."', '".$obUsuario->id_perfil."')");
        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        if($resultado==0){
            throw new Exception("Falha ao inserir o usuario!");
            return false;
        }
        
        $obUsuario->setIdUsuario($con->lastInsertId());
        parent::inserir($obUsuario);
        return true;

    }

}