<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModalLog extends MY_Controller {
    public function carregarLog(){      
        $idComponente   = $this->input->post("idComponente");
        $arComponente = explode(".",$idComponente); 
        $nmComponente = $arComponente[0];
        $id           = $arComponente[1];
        $tableName    = $arComponente[2];

        $obLog = new Log_model();
        $coLog = $obLog->lerTodosPorArrayAtributos(array('tabela'=>$tableName, 'id_alterado'=>$id));
        
        $dados['coLog'] = $coLog;
        echo json_encode(array('lista'=>$this->load->view('modal_detalhe_log', $dados, true)));
        die();
        
    }
}