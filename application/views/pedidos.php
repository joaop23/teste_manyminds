<?php $this->load->view('pagina_inicio'); ?>
<?php $this->load->view('header'); ?>
<div class="table-responsive">
  <div class="row">
    <div class="col-12">
      <button type="button" class="btn btn-dark" onclick="window.location.href ='<?php echo base_url('index.php/pedidos/verInserir');?>'">Cadastrar Pedido</button><br>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <table class="table table-striped table-bordered text-center" id='tablePedidos' name='tablePedidos'>
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">CODIGO</th>
            <th scope="col">STATUS</th>
            <th scope="col">EDITAR</th>
            <th scope="col">EXCLUIR</th>
          </tr>
        </thead>
        <tbody>
          <?php if(count($coPedidos) > 0){
                foreach($coPedidos as $indice=>$pedido){?>
              <tr>
                <th scope="row"><?php echo $indice+1;?></th>
                <td><?php echo $pedido->cd_pedido;?></td>
                <td><?php echo ($pedido->cs_status == 'A') ? "Ativo" : "Finalizado" ?></td>
                <td>
                    <?php if($pedido->cs_status == 'A'){ ?>
                        <a href="javascript:window.location.href ='<?php echo base_url("index.php/pedidos/verAlterar?id=".$pedido->id_pedido);?>'" id='editar_<?php echo $pedido->id_pedido;?>' title='Editar' ><i class="bi bi-pen-fill"></i>
                    <?php } ?>
                </a></td>
                <td>
                    <?php if($pedido->cs_status == 'A'){ ?>
                        <a href='<?php echo base_url("index.php/pedidos/excluir?id=".$pedido->id_pedido);?>' data-bs-target="#modalExcluir" id='excluir' title='Excluir' ><i class="bi bi-x-square-fill"></i>
                    <?php }?>
                    
                </a></td>
              </tr>
            <?php }
             }else{?>
                <tr>
                    <td colspan='7'>Não foram encontrados registros cadastrados.</td>
                </tr>
            <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php $this->load->view('footer'); ?>
<?php $this->load->view('pagina_fim'); ?>


<script language="javascript">
  $(document).ready(function() {
      $('#tablePedidos').DataTable({
  columnDefs: [{
    "defaultContent": "-",
    "targets": "_all"
  }]
});
  } );
</script>