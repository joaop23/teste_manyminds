<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends MY_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/userguide3/general/urls.html
     */
    public function __construct(){
        parent::__construct();        
        $this->load->model('pedidos_model');
        $this->load->model('pedidositens_model');
        $this->load->model('produtos_model');

        $this->dadosTemplates['titulo'] = 'Cadastro de Pedidos';
        $obUsuario = new Usuarios_model();
        $coUsuarios = $obUsuario->lerTodosPorArrayAtributos(array('cs_ativo'=>1));
        $arUsuarios = array();
        foreach($coUsuarios as $obUsuario){
            $arUsuarios[$obUsuario->id_usuario]= $obUsuario->nome;
        }
        $this->dadosTemplates['arUsuarios'] =$arUsuarios; 
        $obProduto = new Produtos_model();
        $coProdutos = $obProduto->lerTodosPorArrayAtributos(array('cs_ativo'=>1));
        $arProdutos = array();
        foreach($coProdutos as $obProduto){
            $arProdutos[$obProduto->id_produto]= $obProduto->nm_produto;
        }
        $this->dadosTemplates['arProdutos'] =$arProdutos;
    }
    public function index()
    {      
        $dados = $this->dadosTemplates;
        $obPedidos = new Pedidos_model();
        $colecaoPedidos = $obPedidos->selecionaTodos();
        $dados['coPedidos'] = $colecaoPedidos;
        $this->load->view('pedidos', $dados);

        
        
    }

    public function excluir(){
        $idPedido = $this->input->get("id");   
        try {
            $obPedido = new Pedidos_model();
            $sucesso = $obPedido->excluir($idPedido);
            if($sucesso){
                echo '<script>alert("Pedido excluído com sucesso!");</script>';
                echo '<script>location.href="'.base_url('index.php/pedidos/').'";</script>';
            }
        } catch (\Throwable $th) {
            $dados['erro'] = "Não foi possivel excluir o pedido! Tente novamente mais tarde.";
            $this->load->view("pedidos");
        }
    }
    
    public function verAlterar(){ 
        $idPedido   = $this->input->get("id"); 
        $dados = $this->dadosTemplates;
        //try{
            $obPedido = new Pedidos_model();
            $obPedido = $obPedido->lerPorId($idPedido);
            $dados['obPedido'] = $obPedido;
            $dados['idPedido'] = $idPedido;

            $obPedidosItem = new PedidosItens_model();
            $coItensPedidos = $obPedidosItem->lerTodosPorArrayAtributos(array('id_pedido'=>$idPedido));
            $dados['coItensPedidos'] = $coItensPedidos;
            $coItensPedidos = $this->session->set_userdata('coItensPedidos',serialize($coItensPedidos));

            
            
            $this->load->view('pedidos_verAlterar', $dados);
       // }catch (\Throwable $th) {
       //     $dados['erro'] = "Não foi possivel entrar na alteração desse o pedido! Tente novamente mais tarde.";
       //     $this->load->view("pedidos", $dados);
      //  }
    }

    public function verInserir(){ 
        $dados = $this->dadosTemplates;
        try{
            $coItensPedidos = array();
            $dados['coItensPedidos'] = $coItensPedidos;

            $obUsuario = new Usuarios_model();
            $coUsuarios = $obUsuario->lerTodosPorArrayAtributos(array('cs_ativo'=>1));
            $arUsuarios = array();
            foreach($coUsuarios as $obUsuario){
                $arUsuarios[$obUsuario->id_usuario]= $obUsuario->nome;
            }
            $dados['arUsuarios'] =$arUsuarios; 
            $obProduto = new Produtos_model();
            $coProdutos = $obProduto->lerTodosPorArrayAtributos(array('cs_ativo'=>1));
            $arProdutos = array();
            foreach($coProdutos as $obProduto){
                $arProdutos[$obProduto->id_produto]= $obProduto->nm_produto;
            }
            $dados['arProdutos'] =$arProdutos;

            
		    $this->load->view('pedidos_verInserir', $dados);
        }catch (\Throwable $th) {
            $dados['erro'] = "Não foi possivel entrar na alteração desse pedido! Tente novamente mais tarde.";
            $this->load->view("pedidos", $dados);
        }
    }

    public function alterar(){
        $idPedido   = $this->input->post("idPedido"); 
        $cdPedido   = $this->input->post("cdPedido"); 
        $idUsuario  = $this->input->post("idUsuario"); 
        $vlTotal    = $this->input->post("vlTotal"); 
        $observacao = $this->input->post("observacao"); 
        
      //  try {
            $obPedido = new Pedidos_model();
            $obPedido = $obPedido->lerPorId($idPedido);
            $obPedidoAntes = clone $obPedido;
            $obPedido->setCdPedido($cdPedido);
            $obPedido->setIdUsuario($idUsuario);
            $obPedido->setVlTotal(number_format($vlTotal, 2, '.', ''));
            $obPedido->setCsStatus('A');
            $obPedido->setObservacao($observacao);
            $obPedido->alterar($obPedido, $obPedidoAntes);

            $obPedidoItem = new PedidosItens_model();
            $obPedidoItem->excluirTodosPorArrayAtributos(array('id_pedido'=>$idPedido));

            $coItensPedidos = $this->session->userdata('coItensPedidos');
            $coItensPedidos = !empty($coItensPedidos) ? unserialize($coItensPedidos) : array();
            if(count($coItensPedidos)){
                foreach($coItensPedidos as $obItemPedido){
                    $obItemPedido->setIdPedido($obPedido->getIdPedido());
                    $obItemPedido->inserir($obItemPedido);
                }
            }

            echo '<script>alert("Pedido alterado com sucesso!");</script>';
            echo '<script>location.href="'.base_url('index.php/pedidos/').'";</script>';
        //} catch (Exception $e) {
       //     $dados['erro'] = "Não foi possivel alterar o o pedido! Tente novamente mais tarde.";
        //    $this->load->view("usuarios");
       // }
    }

    public function inserir(){
        $idPedido   = $this->input->post("idPedido"); 
        $nome        = $this->input->post("nome"); 
        $email       = $this->input->post("email"); 
        $login       = $this->input->post("login"); 
        $senha       = $this->input->post("senha");
        $nr_cgc      = $this->input->post("nr_cgc"); 

        try {
            
            $obPedido = new Pedidos_model();
            $obPedido->setNome($nome);
            $obPedido->setEmail($email);
            $obPedido->setLogin($login);
            $obPedido->setSenha($senha);
            $obPedido->setNrCgc($nr_cgc);
            $obPedido->setCsAtivo(1);
            $obPedido->setCsPessoa(strlen($nr_cgc)==11 ? 'F' : 'J');
            $obPedido->inserir($obPedido);

            $coItensPedidos = $this->session->userdata('coItensPedidos');
            $coItensPedidos = !empty($coItensPedidos) ? unserialize($coItensPedidos) : array();
            if(count($coItensPedidos)){
                foreach($coItensPedidos as $obItemPedido){
                    $obItemPedido->setIdPedido($obPedido->getIdPedido());
                    $obItemPedido->inserir($obItemPedido);
                }
            }

            echo '<script>alert("Usuário inserido com sucesso!");</script>';
            echo '<script>location.href="'.base_url('index.php/usuarios/').'";</script>';
        } catch (Exception $e) {
            $dados['erro'] = "Não foi possivel alterar o o pedido! Tente novamente mais tarde.";
            $this->load->view("usuarios");
        }
    }

    public function incluirPedidoItem(){
        $idProduto  = $this->input->post("idProduto"); 
        $qtItem     = $this->input->post("qtItem"); 
        $vlItem     = $this->input->post("vlItem");         
        $vlItem     = str_replace(".", "", $vlItem);
        $vlItem     = str_replace(",", ".", $vlItem); 

        
        $coItensPedidos = $this->session->userdata('coItensPedidos');
        $coItensPedidos = !empty($coItensPedidos) ? unserialize($coItensPedidos) : array();
        $obItemPedido = new PedidosItens_model();
        $obItemPedido->setIdProduto($idProduto);
        $obItemPedido->setQtItem($qtItem);
        $obItemPedido->setVlItem($vlItem);
        
        $coItensPedidos[] = $obItemPedido;
        $this->session->set_userdata('coItensPedidos', serialize($coItensPedidos));
        $dados['coItensPedidos'] = $coItensPedidos;
        echo json_encode(array('lista'=>$this->load->view('pedidos_itens', $dados, true)));
        die();
        
    }

    public function listarItens($coItensPedidos){
        $obPedido = new Pedidos_model();
        $colecaoPedidos = $obPedido->selecionaTodos();
    }

    public function excluirPedidoItem(){
        $indice = $this->input->post("indice"); 
        
        $coItensPedidos = $this->session->userdata('coItensPedidos');
        $coItensPedidos = !empty($coItensPedidos) ? unserialize($coItensPedidos) : array();
        unset($coItensPedidos[$indice]);

        $this->session->set_userdata('coItensPedidos', serialize($coItensPedidos));
        $dados['coItensPedidos'] = $coItensPedidos;
        echo json_encode(array('lista'=>$this->load->view('pedidos_itens', $dados, true)));
        die();        
    }

    function carregarPedidoItem(){
        $indice = $this->input->post("indice"); 
        
        $coItensPedidos = $this->session->userdata('coItensPedidos');
        
        $coItensPedidos = !empty($coItensPedidos) ? unserialize($coItensPedidos) : array();
        $obItemPedido = $coItensPedidos[$indice];

        echo json_encode(array('indice'=>$indice,
                               'idProduto'=>$obItemPedido->id_produto,
                               'qtItem'=>$obItemPedido->qt_item,
                               'vlItem'=>number_format($obItemPedido->vl_item, 2, ',', '.')));
        die();

    }

    function alterarPedidoItem(){
        
        $idProduto  = $this->input->post("idProduto"); 
        $qtItem     = $this->input->post("qtItem"); 
        $vlItem     = $this->input->post("vlItem");         
        $vlItem     = str_replace(".", "", $vlItem);
        $vlItem     = str_replace(",", ".", $vlItem);
        $indice     = $this->input->post("indice"); 
        $coItensPedidos = $this->session->userdata('coItensPedidos');
        $coItensPedidos = !empty($coItensPedidos) ? unserialize($coItensPedidos) : array();

        $obItemPedido = new PedidosItens_model();
        $obItemPedido->setIdProduto($idProduto);
        $obItemPedido->setQtItem($qtItem);
        $obItemPedido->setVlItem($vlItem);
        $dados = $this->dadosTemplates;
        $coItensPedidos[$indice] = $obItemPedido;
        $this->session->set_userdata('coItensPedidos', serialize($coItensPedidos));
        $dados['coItensPedidos'] = $coItensPedidos;
        echo json_encode(array('lista'=>$this->load->view('pedidos_itens', $dados, true)));
        die();
    }

    public function calcularValorTotalPedido(){
        $coItensPedidos = $this->session->userdata('coItensPedidos');
        
        $coItensPedidos = !empty($coItensPedidos) ? unserialize($coItensPedidos) : array();
        $vlTotal = 0;
        foreach($coItensPedidos as $obItemPedido){
            $vlTotal = ($obItemPedido->qt_item * $obItemPedido->vl_item);
        }
        echo json_encode(array('vlTotal'=>number_format($vlTotal, 2, ',', '.')));
        die();
    }
    
}