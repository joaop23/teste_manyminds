<?php
    class MY_Model extends CI_Model{
        public $nomeTabela   = '';
        public $nomeModel    = '';
        public $nomeIdTabela = '';
        
        public function __construct(){
            parent::__construct();   
            
            $this->load->model('log_model'); 
            $this->load->model('detalhelog_model');          
        }

        public function selecionaTodos(){
            $con = Connection::getConn();
            $sql = "SELECT * FROM ".$this->nomeTabela;
            $sql = $con->prepare($sql);
            $sql->execute();
            
            $resultado = array();
            while($row = $sql->fetchObject($this->nomeModel)){
                $resultado[] = $row;
            }
            return $resultado;
        }
        public function lerPorId($id){
            $con = Connection::getConn();
            $sql = "SELECT * FROM ".$this->nomeTabela." WHERE ".$this->nomeIdTabela."='".$id."'";
            $sql = $con->prepare($sql);
            $sql->execute();
            $resultado = new $this->nomeModel;
            while($row = $sql->fetchObject($this->nomeModel)){
                $resultado = $row;
            }
            return $resultado;
        }

        public  function lerTodosPorArrayAtributos($arAtributos){
            $con = Connection::getConn();
            $sql = "SELECT * FROM ".$this->nomeTabela." WHERE ";
            foreach($arAtributos as $campo=>$valor){
                $sql .= " ".$campo." = '".$valor."' AND ";
            }
            $sql = substr($sql, 0, strlen($sql)-4);
            
            $sql = $con->prepare($sql);
            $sql->execute();
            $resultado = array();
            while($row = $sql->fetchObject($this->nomeModel)){
                
                $resultado[] = $row;
            }
            return $resultado;
        }
        public  function lerPorArrayAtributos($arAtributos){
            $con = Connection::getConn();
            $sql = "SELECT * FROM ".$this->nomeTabela." WHERE ";
            foreach($arAtributos as $campo=>$valor){
                if(is_array($valor)){
                    foreach($valor as $indice=>$vl){
                        if(is_array($vl)){
                                $sql .= " ".$campo." ".$indice." ".$vl[0]." AND ".$vl[1]." AND ";
                        }else{
                            $sql .= " ".$campo." ".$indice." ".$vl." AND ";
                        }
                    }
                }else{
                    $sql .= " ".$campo." = '".$valor."' AND ";
                }
            }
            
            $sql = substr($sql, 0, strlen($sql)-4);
            $sql = $con->prepare($sql);
            $sql->execute();
            $resultado = new $this->nomeModel();
            while($row = $sql->fetchObject($this->nomeModel)){
                
                $resultado = $row;
            }
    
            return $resultado;
        }

        
    public function excluirTodosPorArrayAtributos($arAtributos){
        $con = Connection::getConn();
        $sql = "DELETE FROM ".$this->nomeTabela." WHERE ";
        foreach($arAtributos as $campo=>$valor){
            $sql .= " ".$campo." = '".$valor."' AND ";
        }
        $sql = substr($sql, 0, strlen($sql)-4);

        $sql = $con->prepare($sql);
        $resultado = $sql->execute();
        
        if($resultado==0){
            throw new Exception("Falha ao excluir!");
            return false;
        }
        return true;
    }

    public function inserir($objeto){
        
        $dtAlteracao = date('Y-m-d H:i:s');
        $ip          = $this->input->ip_address();
        $obUsuario   = unserialize($this->session->userdata('usuarioLogado'));
		$id = $this->nomeIdTabela;
        $obLog = new Log_model();
        $obLog->setDtAlteracao($dtAlteracao);
        $obLog->setTabela($this->nomeTabela);
        $obLog->setOperacao("I");
        $obLog->setNrIp($ip);
        $obLog->setIdAlterado($objeto->$id);
        $obLog->setIdUsuario($obUsuario->getIdUsuario());
        $obLog->inserir($obLog);

        $arObjeto = $this->object_to_array($objeto);
        foreach($arObjeto as $nomeCampo=>$valor){
            if($nomeCampo != "nomeTabela" && $nomeCampo != "nomeModel" && $nomeCampo != "nomeIdTabela"){
                $obDetalheLog = new DetalheLog_model();
                $obDetalheLog->setIdLog($obLog->getIdLog());
                $obDetalheLog->setAtributo($nomeCampo);
                $obDetalheLog->setValor($valor);
                $obDetalheLog->setValorNovo('');
                $obDetalheLog->inserir($obDetalheLog);
            }
        }

    }
    public function alterar($objeto, $objetoAntesAlteracao){
        $dtAlteracao = date('Y-m-d H:i:s');
        $ip          = $this->input->ip_address();
        $obUsuario   = unserialize($this->session->userdata('usuarioLogado'));
		    
        $obLog = new Log_model();
        $obLog->setDtAlteracao($dtAlteracao);
        $obLog->setTabela($this->nomeTabela);
        $obLog->setOperacao("A");
        $obLog->setNrIp($ip);
        $obLog->setIdAlterado($objeto->$id);
        $obLog->setIdUsuario($obUsuario->getIdUsuario());
        $obLog->inserir($obLog);
        $arObjeto      = $this->object_to_array($objeto);
        $arObjetoAntes = $this->object_to_array($objetoAntesAlteracao);
        foreach($arObjeto as $nomeCampo=>$valor){
            if($nomeCampo != "nomeTabela" && $nomeCampo != "nomeModel" && $nomeCampo != "nomeIdTabela"){
                $obDetalheLog = new DetalheLog_model();
                $obDetalheLog->setIdLog($obLog->getIdLog());
                $obDetalheLog->setAtributo($nomeCampo);
                $obDetalheLog->setValor($arObjetoAntes[$nomeCampo]);
                $obDetalheLog->setValorNovo($valor);
                $obDetalheLog->inserir($obDetalheLog);
            }
        }
    }
    public function excluir($id){
        
    }

    function object_to_array($data)
    {
        if (is_array($data) || is_object($data))
        {
            $result = [];
            foreach ($data as $key => $value)
            {
                $result[$key] = (is_array($value) || is_object($value)) ? object_to_array($value) : $value;
            }
            return $result;
        }
        return $data;
    }

        
    }