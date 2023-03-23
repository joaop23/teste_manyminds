<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
    public function __construct(){
        parent::__construct();
            
		$this->load->model('produtos_model');
        $this->dadosTemplates['titulo'] = 'Cadastro de Produtos';
    }
	public function index()
	{
        $dados = $this->dadosTemplates;
        $obPedido = new Produtos_model();
        $colecaoProduto = $obPedido->selecionaTodos();
        $dados['coProdutos'] = $colecaoProduto;
        $dados['tableName']  = 'produtos';
		$this->load->view('produtos', $dados);
	}

    public function desativar(){
        $idProduto = $this->input->get("id_produto");   
        try {
            $obProduto = new Produtos_model();
            $sucesso = $obProduto->ativarOuDesativarProduto($idProduto,0);
            if($sucesso){
                echo '<script>alert("Produto Desativado com sucesso!");</script>';
                echo '<script>location.href="'.base_url('index.php/produtos/').'";</script>';
            }
        } catch (\Throwable $th) {
            $dados['erro'] = "Não foi possivel desativar produto! Tente novamente mais tarde.";
            $this->load->view("produtos");
        }
    }

    public function ativar(){
        $idProduto = $this->input->get("id_produto");   
        try {
            $obProduto = new Produtos_model();
            $sucesso = $obProduto->ativarOuDesativarProduto($idProduto,1);
            if($sucesso){
                echo '<script>alert("Produto Ativado com sucesso!");</script>';
                echo '<script>location.href="'.base_url('index.php/produtos/').'";</script>';
            }
        } catch (\Throwable $th) {
            $dados['erro'] = "Não foi possivel ativar produto! Tente novamente mais tarde.";
            $this->load->view("produtos");
        }
    }
    
    public function verAlterar(){ 
        $idProduto   = $this->input->get("id"); 
        try{
            $dados = $this->dadosTemplates;
            
            $obProduto = new Produtos_model();
            $obProduto = $obProduto->lerPorId($idProduto);
            $dados['obProduto'] = $obProduto;
            $dados['idProduto'] = $idProduto;
		    $this->load->view('produtos_verAlterar', $dados);
        }catch (\Throwable $th) {
            $dados['erro'] = "Não foi possivel entrar na alteração desse produto! Tente novamente mais tarde.";
            $this->load->view("produtos");
        }
    }

    public function verInserir(){ 
        try{
            
            $dados = $this->dadosTemplates;
		    $this->load->view('produtos_verInserir', $dados);
        }catch (\Throwable $th) {
            $dados['erro'] = "Não foi possivel entrar na alteração desse produto! Tente novamente mais tarde.";
            $this->load->view("produtos");
        }
    }

    public function alterar(){
        $idProduto   = $this->input->post("idProduto"); 
        $nmProduto   = $this->input->post("nmProduto"); 
        $cdProduto   = $this->input->post("cdProduto"); 
        try {
            $obProduto = new Produtos_model();
            $obProduto = $obProduto->lerPorId($idProduto);
            $obProdutoAntes = clone $obProduto;
            $obProduto->setNmProduto($nmProduto);
            $obProduto->setCdProduto($cdProduto);
            $obProduto->setCsAtivo(1);
            $obProduto->alterar($obProduto, $obProdutoAntes);

            echo '<script>alert("Produto alterado com sucesso!");</script>';
            echo '<script>location.href="'.base_url('index.php/produtos/').'";</script>';
        } catch (Exception $e) {
            $dados['erro'] = "Não foi possivel alterar o produto! Tente novamente mais tarde.";
            $this->load->view("produtos");
        }
    }

    public function inserir(){
        $idProduto   = $this->input->post("idProduto"); 
        $nmProduto   = $this->input->post("nmProduto"); 
        $cdProduto   = $this->input->post("cdProduto"); 

        //try {
            $obProduto = new Produtos_model();
            $obProduto->setNmProduto($nmProduto);
            $obProduto->setCdProduto($cdProduto);
            $obProduto->setCsAtivo(1);
            $obProduto->inserir($obProduto);

            echo '<script>alert("Produto inserido com sucesso!");</script>';
            echo '<script>location.href="'.base_url('index.php/produtos/').'";</script>';
       // } catch (Exception $e) {
      //      $dados['erro'] = "Não foi possivel alterar o produto! Tente novamente mais tarde.";
       //     $this->load->view("produtos");
       // }
    }
}
