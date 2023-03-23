<?php $this->load->view('pagina_inicio'); ?>
<?php $this->load->view('header'); ?>
<div class="table-responsive">
  <div class="row">
    <div class="col-12">
      <button type="button" class="btn btn-dark" onclick="window.location.href ='<?php echo base_url('index.php/produtos/verInserir');?>'">Cadastrar Produto</button><br>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <table class="table table-striped table-bordered text-center" id='tableProdutos' name='tableProdutos'>
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">CÓDIGO</th>
            <th scope="col">NOME</th>
            <th scope="col">EDITAR</th>
            <th scope="col">ATIVAR/DESATIVAR</th>
            <th scope="col">LOG</th>
          </tr>
        </thead>
        <tbody>
          <?php if(count($coProdutos) > 0){
                foreach($coProdutos as $indice=>$produto){?>
              <tr>
                <th scope="row"><?php echo $indice+1;?></th>
                <td><?php echo $produto->cd_produto;?></td>
                <td><?php echo $produto->nm_produto;?></td>
                <td>
                    <?php if($produto->cs_ativo == 1){ ?>
                        <a href="javascript:window.location.href ='<?php echo base_url("index.php/produtos/verAlterar?id=".$produto->id_produto);?>'" id='editar_<?php echo $produto->id_produto;?>' title='Editar' ><i class="bi bi-pen-fill"></i>
                    <?php } ?>
                </a></td>
                <td>
                    <?php if($produto->cs_ativo == 1){ ?>
                        <a href="" data-bs-toggle="modal" data-bs-target="#modalDesativar" id='desativar' title='Desativar' ><i class="bi bi-x-square-fill"></i>
                    <?php }else{ ?>
                        <a href="<?php echo base_url('index.php/produtos/ativar?id_produto='.$produto->id_produto);?>" id='ativar' title='Ativar' ><i class="bi bi-check-circle-fill"></i>
                    <?php } ?>
                    
                </a></td>
                <div class="modal" tabindex="-1" id="modalDesativar" name='modalDesativar'>
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Desativar Usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <p>Deseja mesmo desativar esse produto?</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="window.location.href ='<?php echo base_url('index.php/produtos/desativar?id_produto='.$produto->id_produto);?>'">Sim</button>
                      </div>
                    </div>
                  </div>
                </div>
                <td><a href="" data-bs-toggle="modal" class="open-AddBookDialog btn btn-primary"  data-id="id_produto.<?=$produto->id_produto;?>.<?=$tableName?>" data-bs-target="#modalLog" id='log' title='Log' ><i class="bi bi-door-open-fill"></i></a>
                      
                  <?php $this->load->view('modal_log'); ?>
                </td>
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
      $('#tableProdutos').DataTable({
  columnDefs: [{
    "defaultContent": "-",
    "targets": "_all"
  }]
});
  } );
</script>