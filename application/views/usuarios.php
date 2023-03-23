<?php $this->load->view('pagina_inicio'); ?>
<?php $this->load->view('header'); ?>
<div class="table-responsive">
  <div class="row">
    <div class="col-12">
      <button type="button" class="btn btn-dark" onclick="window.location.href ='<?php echo base_url('index.php/usuarios/verInserir');?>'">Cadastrar Usuário</button><br>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <table class="table table-striped table-bordered text-center" id='tableUsuarios' name='tableUsuarios'>
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">NOME</th>
            <th scope="col">EMAIL</th>
            <th scope="col">DOCUMENTO</th>
            <th scope="col">STATUS</th>
            <th scope="col">PESSOA</th>
            <th scope="col">EDITAR</th>
            <th scope="col">ATIVAR/DESATIVAR</th>
          </tr>
        </thead>
        <tbody>
          <?php if(count($coUsuarios) > 0){
                foreach($coUsuarios as $indice=>$usuario){?>
              <tr>
                <th scope="row"><?php echo $indice+1;?></th>
                <td><?php echo $usuario->nome;?></td>
                <td><?php echo $usuario->email;?></td>
                <td><?php echo $usuario->nr_cgc;?></td>
                <td><?php echo ($usuario->cs_ativo ? 'Ativo' : 'Desativado') ;?></td>
                <td><?php echo $usuario->cs_pessoa =='J' ? 'Juridica' : 'Fisica';?></td>
                <td>
                    
                    <?php if($usuario->cs_ativo == 1){ ?>   
                        <a href="javascript:window.location.href ='<?php echo base_url("index.php/usuarios/verAlterar?id=".$usuario->id_usuario);?>'" id='editar_<?php echo $usuario->id_usuario;?>' title='Editar' ><i class="bi bi-pen-fill"></i>
                    <?php } ?>
                </a></td>
                <td>
                    <?php if($usuario->cs_ativo == 1){ ?>
                        <a href="" data-bs-toggle="modal" data-bs-target="#modalDesativar"  id='desativar' title='Desativar' ><i class="bi bi-x-square-fill"></i>
                    <?php }else{ ?>
                        <a href="<?php echo base_url('index.php/usuarios/ativar?id_usuario='.$usuario->id_usuario);?>" id='ativar' title='Ativar' ><i class="bi bi-check-circle-fill"></i>
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
                        <p>Deseja mesmo desativar esse usuario?</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="window.location.href ='<?php echo base_url('index.php/usuarios/desativar?id_usuario='.$usuario->id_usuario);?>'">Sim</button>
                      </div>
                    </div>
                  </div>
                </div>
              </tr>
            <?php }
             }else{ ?>
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
      $('#tableUsuarios').DataTable({
  columnDefs: [{
    "defaultContent": "-",
    "targets": "_all"
  }]
});
  } );
</script>