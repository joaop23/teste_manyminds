<?php $this->load->view('pagina_inicio'); ?>
<?php $this->load->view('header'); ?>
<br>
<form action='<?php echo base_url("index.php/pedidos/inserir"); ?>' method='post' enctype="multipart/form-data" >
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <button type="submit" class="btn btn-dark" type="submit">Inserir</button>
        <button type="button" type="submit" class="btn btn-secondary" onclick="window.location.href ='<?php echo base_url('index.php/pedidos') ;?>'">Listagem</button>
      </div>
    </div><br>
    <div class="row">
      <fieldset class="border p-2">
        <legend class="float-none w-auto">Cadastro de Pedidos</legend>
        <div class="control-group ">
            
          <div class="row">
            <div class="col-4">
                <label for="txDescricao">Código</label>
                <input type="text" class="form-control" value="" id="cdPedido" name="cdPedido" placeholder="Digite um pedido">
            </div>
            <div class="col-4">
                <label for="txDescricao">Usuario</label>
                <select class="form-select" aria-label="Default select example" id="usuario" name="usuario">
                    <option selected>Selecione</option>
                    <?php foreach($arUsuarios as $idUsuario=>$nmUsuario){ ?>
                        <option value="<?=$idUsuario;?>"><?=$nmUsuario;?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-4">
                <label for="txDescricao">Valor Total</label>
                <input type="numeric" class="form-control" value="0,00" id="vlTotal" name="vlTotal" placeholder="Digite um valor total">
            </div>
          <div class="form-group">
            <label for="txDescricao">Observação</label>
            <textarea class="form-control" value="" id="obervacao" name="obervacao" rows="3" placeholder="Digite uma observação"></textarea>
          </div></div><br>
          
          <?php $this->load->view('pedidos_itens', $coItensPedidos); ?>
      
          </div>
        </div>
      </fieldset>
    </div>
  </div>
</form>

<?php $this->load->view('footer'); ?>
<?php $this->load->view('pagina_fim'); ?>