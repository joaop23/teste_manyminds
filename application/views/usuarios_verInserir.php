<?php $this->load->view('pagina_inicio'); ?>
<?php $this->load->view('header'); ?>
<br>
<form action='<?php echo base_url("index.php/usuarios/inserir"); ?>' method='post' enctype="multipart/form-data" >
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <button type="submit" class="btn btn-dark" type="submit">Inserir</button>
        <button type="button" type="submit" class="btn btn-secondary" onclick="window.location.href ='<?php echo base_url('index.php/usuarios') ;?>'">Listagem</button>
      </div>
    </div><br>
    <div class="row">
      <fieldset class="border p-2">
        <legend class="float-none w-auto">Cadastro de Usuários</legend>
        <div class="control-group ">
          <div class="form-group">
            <label for="txDescricao">Nome</label>
            <input type="text" class="form-control" value="" id="nome" name="nome" placeholder="Digite um nome">
          </div>
          <div class="form-group">
            <label for="txDescricao">Email</label>
            <input type="text" class="form-control" value="" id="email" name="email" placeholder="Digite um email">
          </div>
          <div class="row">

            <div class="col-6">
              <label for="txDescricao">Senha</label>
              <input type="password" class="form-control" value="" id="senha" name="login"  placeholder="Digite uma senha">
            </div>
            <div class="col-6">
              <label for="txDescricao">Documento</label>
              <input type="text" class="form-control" value="" id="nr_cgc" name="nr_cgc"  placeholder="Digite um CPF/CNPJ">
            </div>
           <div class="col-4">
              <label for="txDescricao">Tipo</label>
              <select class="form-select" id="idPerfil" name="idPerfil" aria-label="Selecione o perfil">
                  <?php foreach($arPerfis as $obPerfil){?>
                      <option value="<?=$obPerfil->id_perfil;?>"><?=$obPerfil->nm_perfil;?></option>
                  <?php } ?>
              </select></div><br>
          
          <?php $this->load->view('usuarios_enderecos', array('coEnderecosUsuarios'=>$coEnderecosUsuarios)); ?>
      
          </div>
        </div>
      </fieldset>
    </div>
  </div>
</form>

<?php $this->load->view('footer'); ?>
<?php $this->load->view('pagina_fim'); ?>