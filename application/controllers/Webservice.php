<?php
class Webservice extends CI_controller {
    function __construct() {
        parent::__construct();

        $this->load->library("nusoap_lib");
        $this->load->model("Pedidos_model");

        $this->nusoap_server = new soap_server();
        $this->nusoap_server->configureWSDL("Webservice_WSDL", "urn:Webservice_WSDL");

        $this->nusoap_server->register('consultarPedidos',   // method name
            array(),        // input parameters
            array('return' => 'xsd:string'),      // output parameters
            'urn:Bills_WSDL',                      // namespace
            'urn:Bills_WSDL#consultarPedidos',                // soapaction
            'rpc',                                // style
            'encoded',                            // use
            'Says hello to the caller'            // documentation
        );
    }

    function index(){

        if($this->uri->rsegment(3) == "wsdl") {
            $_SERVER['QUERY_STRING'] = "wsdl";
        } else {
            $_SERVER['QUERY_STRING'] = "";
        }        

        function consultarPedidos() {
            $this->load->model('pedidos_model');
            $this->load->model('pedidositens_model');
            $this->load->model('produtos_model');
            $this->load->model('Usuarios_model');
            $arRetorno = array();
            $obPedidos = new Pedidos_model();
            $coPedidos = $obPedidos->lerTodosPorArrayAtributos(array('cs_status'=>'F'));
            if(count($coPedidos)>0){
                foreach($coPedidos as $indice=>$obPedido){
                    $arRetorno[$indice]['codigoPedido']     = $obPedido->getCdPedido();
                    $arRetorno[$indice]['statusPedido']     = $obPedido->getCsStatus();
                    $arRetorno[$indice]['vlTotalPedido']    = $obPedido->getVlTotal();
                    $arRetorno[$indice]['observacaoPedido'] = $obPedido->getObservacao();

                    $obUsuario = new Usuarios_model();
                    $obUsuario = $obUsuario->lerPorId($obPedido->getIdUsuario());
                    $arRetorno[$indice]['fornecedor']['nome'] = $obUsuario->getNome();
                    $arRetorno[$indice]['fornecedor']['email'] = $obUsuario->getEmail();
                    $arRetorno[$indice]['fornecedor']['documento'] = $obUsuario->getNrCgc();
                    
                    $obPedidoItem = new PedidosItens_model();
                    $coPedidoItem = $obPedidoItem->lerTodosPorArrayAtributos(array('id_pedido'=>$obPedido->id_pedido));
                    if(count($coPedidoItem)){
                        foreach($coPedidoItem as $indItem=>$obPedidoItem){
                            $obProduto = new Produtos_model();
                            $obProduto = $obProduto->lerPorId($obPedidoItem->getIdProduto());
                            $arRetorno[$indice]['coItens'][$indItem]['produto'] = $obProduto->getNmProduto();
                            $arRetorno[$indice]['coItens'][$indItem]['quantidade'] = $obPedidoItem->getQtItem();
                            $arRetorno[$indice]['coItens'][$indItem]['valor'] = $obPedidoItem->getVlItem();
                        } 
                    }

                    $obLog = new Log_model();
                    $obLog = $obLog->lerPorArrayAtributos(array('id_alterado'=>$obPedido->id_pedido, 'operacao'=>'I'));

                    $obUsuarioCriador = new Usuarios_model();
                    $obUsuarioCriador = $obUsuarioCriador->lerPorId($obLog->getIdUsuario());
                    $arRetorno[$indice]['usuarioCriador']['nome'] = $obUsuarioCriador->getNome();
                }
            }
            return json_encode($arRetorno);
        }
        $this->nusoap_server->service(file_get_contents("php://input"));
    }

}