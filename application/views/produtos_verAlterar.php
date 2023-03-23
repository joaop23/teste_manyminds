<?php $this->load->view('pagina_inicio'); ?>
<?php $this->load->view('header'); ?>
<br>
<form action='<?php echo base_url("index.php/produtos/alterar"); ?>' method='post' enctype="multipart/form-data" >
  <input type='hidden' name='idProduto' id='idProduto' value='<?php echo $idProduto;?>' />
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <button type="submit" class="btn btn-dark" type="submit">Alterar</button>
        <button type="button" type="submit" class="btn btn-secondary" onclick="window.location.href ='<?php echo base_url('index.php/produtos') ;?>'">Listagem</button>
      </div>
    </div><br>
    <div class="row">
      <fieldset class="border p-2">
        <legend class="float-none w-auto">Cadastro de Produtos</legend>
        <div class="control-group ">
          <div class="form-group">
            <label for="txDescricao">Código</label>
            <input type="text" class="form-control" value="<?php echo $obProduto->cd_produto; ?>" id="cdProduto" name="cdProduto" placeholder="Digite um código">
          </div>
          <div class="form-group">
            <label for="txDescricao">Nome</label>
            <input type="text" class="form-control" value="<?php echo $obProduto->nm_produto; ?>" id="nmProduto" name="nmProduto" placeholder="Digite um nome">
          </div>
        </div>
      </fieldset>
    </div>
  </div>
</form>

<?php $this->load->view('footer'); ?>
<?php $this->load->view('pagina_fim'); ?>