<?php $this->load->view('pagina_inicio'); ?>
<?php $this->load->view('header'); ?>
<br>
<form action='<?php echo base_url("index.php/pedidos/alterar"); ?>' method='post' enctype="multipart/form-data" >
  <input type='hidden' name='idPedido' id='idPedido' value='<?php echo $idPedido;?>' />
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <button type="submit" class="btn btn-dark" type="submit">Alterar</button>
        <button type="button" type="submit" class="btn btn-secondary" onclick="window.location.href ='<?php echo base_url('index.php/pedidos') ;?>'">Listagem</button>
      </div>
    </div><br>
    <div class="row">
      <fieldset class="border p-2">
        <legend class="float-none w-auto">Cadastro de Pedidos</legend>
        <div class="row">
            <div class="col-4">
                <label for="txDescricao">Código</label>
                <input type="text" class="form-control" value="<?php echo $obPedido->cd_pedido; ?>" id="cdPedido" name="cdPedido" placeholder="Digite um pedido">
            </div>
            <div class="col-4">
                <label for="txDescricao">Usuario</label>
                <select class="form-select" aria-label="Default select example" id="idUsuario" name="idUsuario">
                    <option selected>Selecione</option>
                    <?php foreach($arUsuarios as $idUsuario=>$nmUsuario){ ?>
                        <option value="<?=$idUsuario;?>" <?php echo ($obPedido->id_usuario == $idUsuario  ? 'selected':''); ?>><?=$nmUsuario;?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-4">
                <label for="txDescricao">Valor Total</label>
                <input type="numeric" class="form-control" value="<?php echo $obPedido->vl_total; ?>" id="vlTotal" name="vlTotal" placeholder="Digite um valor total">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="txDescricao">Observacao</label>
                <textarea type="text" rows="3" class="form-control" id="observacao" name="observacao" placeholder="Digite uma observação"><?php echo $obPedido->observacao; ?></textarea>
            </div>
        </div><br>
          
          <?php $this->load->view('pedidos_itens', array('coItensPedidos'=>$coItensPedidos)); ?>
        </div>
      </fieldset>
    </div>
  </div>
</form>

<?php $this->load->view('footer'); ?>
<?php $this->load->view('pagina_fim'); ?>