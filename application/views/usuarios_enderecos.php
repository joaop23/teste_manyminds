<fieldset class="border p-2"  id="tdTableEnderecos">
<legend class="float-none w-auto">Endereços</legend>
<div class="form-group">
    <label for="txDescricao">Logradouro</label>
    <input type="text" class="form-control" value="" id="logradouro" name="logradouro" placeholder="Digite um endereço">
</div>
<div class="row">
    <div class="col-4">
        <label for="txDescricao">Numero</label>
        <input type="text" class="form-control" value="" id="numero" name="numero"  placeholder="Digite um numero">
    </div>
    <div class="col-8">
        <label for="txDescricao">Complemento</label>
        <input type="text" class="form-control" value="" id="complemento" name="complemento"  placeholder="Digite um complemento">
    </div>
</div>
<div class="row">
    <div class="col-4">
        <label for="txDescricao">Bairro</label>
        <input type="text" class="form-control" value="" id="bairro" name="bairro"  placeholder="Digite um bairro">
    </div>
    <div class="col-4">
        <label for="txDescricao">Cidade</label>
        <input type="text" class="form-control" value="" id="cidade" name="cidade"  placeholder="Digite uma cidade">
    </div>
    <div class="col-4">
        <label for="txDescricao">CEP</label>
        <input type="text" class="form-control" value="" id="nrCep" name="nrCep"  placeholder="Digite um CEP">
    </div>
</div><br>
<div class="row">
    <div class="col-5">&nbsp;</div>
    <div class="col-4">
        <button type="button" class="btn btn-light" id='btnIncluir' name='btnIncluir' onclick='incluirEndereco();'>Incluir Endereço</button>
        <button style='display:none' type="button" class="btn btn-light" id='btnAlterar' name='btnAlterar' onclick='alterarEndereco();'>Alterar Endereço</button>
    </div>
</div><br>
<div class="row">
    <table class="table table-striped table-bordered text-center" id='tableEnderecos' name='tableEnderecos'>
        <thead class="thead-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col">LOGRADOURO</th>
            <th scope="col">CEP</th>
            <th scope="col">CIDADE</th>
            <th scope="col">BAIRRO</th>
            <th scope="col">EDITAR</th>
            <th scope="col">EXCLUIR</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!is_array($coEnderecosUsuarios)){
                $coEnderecosUsuarios = unserialize($this->session->userdata('coEnderecosUsuarios'));
            }
            if(count($coEnderecosUsuarios) > 0){
                foreach($coEnderecosUsuarios as $indice=>$endereco){?>
                <tr>
                <th scope="row"><input type='hidden' id='indice' name='indice'><?php echo $indice+1;?></th>
                <td><?php echo $endereco->logradouro;?></td>
                <td><?php echo $endereco->nr_cep;?></td>
                <td><?php echo $endereco->nm_cidade;?></td>
                <td><?php echo $endereco->nm_bairro;?></td>
                <td><a href="javascript:carregarEndereco(<?=$indice;?>);" id='editar_<?php echo $endereco->id_endereco;?>' title='Editar' ><i class="bi bi-pen-fill"></i></a></td>
                <td><a href="" data-bs-toggle="modal" data-bs-target="#modalExcluir" id='excluir' title='Excluir' ><i class="bi bi-x-square-fill"></i></a></td>
                <div class="modal" tabindex="-1" id="modalExcluir" name='modalExcluir'>
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Excluir Endereço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <p>Deseja mesmo excluir esse endereço?</p>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="excluirEndereco('<?=$indice?>');">Sim</button>
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
</fieldset>
    
<script type='text/javascript'>
    function incluirEndereco(){
        var logradouro = $("#logradouro").val();
        var numero     = $("#numero").val();
        var complemento= $("#complemento").val();
        var bairro     = $("#bairro").val();
        var cidade     = $("#cidade").val();
        var nrCep      = $("#nrCep").val();

        if(!logradouro){
            alert("O campo [Logradouro] é obrigatório!");
            return false;
        }
        if(!numero){
            alert("O campo [Numero] é obrigatório!");
            return false;
        }
        if(!bairro){
            alert("O campo [Bairro] é obrigatório!");
            return false;
        }
        if(!cidade){
            alert("O campo [Cidade] é obrigatório!");
            return false;
        }
        if(!nrCep){
            alert("O campo [CEP] é obrigatório!");
            return false;
        }
        
        $.ajax({
            url:'<?=base_url()?>index.php/usuarios/incluirEndereco',
            method: 'post',
            data: {
                    logradouro : logradouro,
                    numero     : numero,
                    complemento: complemento,
                    bairro     : bairro,
                    cidade     : cidade,
                    nrCep      : nrCep
                  },
            dataType: 'json',
            success: function(response){
                $("#tdTableEnderecos").html(response.lista);
            }
        });
    }

    function excluirEndereco(indice){
        $.ajax({
            url:'<?=base_url()?>index.php/usuarios/excluirEndereco',
            method: 'post',
            data: {
                    indice : indice
                  },
            dataType: 'json',
            success: function(response){
                    $("#tdTableEnderecos").html(response.lista);
                $(".modal-backdrop").hide();
                $("body").removeClass();
                $("body").removeAttr('style');
            }
        });
    }

    function carregarEndereco($indice){
        $.ajax({
            url:'<?=base_url()?>index.php/usuarios/carregarEndereco',
            method: 'post',
            data: {
                    indice : $indice
                  },
            dataType: 'json',
            success: function(response){
                $("#indice").val(response.indice);
                $("#logradouro").val(response.logradouro);
                $("#numero").val(response.numero);
                $("#complemento").val(response.complemento);
                $("#bairro").val(response.bairro);
                $("#cidade").val(response.cidade);
                $("#nrCep").val(response.nrCep);
                
                $("#btnIncluir").attr("style","display:none");
                $("#btnAlterar").removeAttr("style");
            }
        });
    }

    function alterarEndereco(){
        var logradouro = $("#logradouro").val();
        var numero     = $("#numero").val();
        var complemento= $("#complemento").val();
        var bairro     = $("#bairro").val();
        var cidade     = $("#cidade").val();
        var nrCep      = $("#nrCep").val();
        var indice     = $("#indice").val();

        if(!logradouro){
            alert("O campo [Logradouro] é obrigatório!");
            return false;
        }
        if(!numero){
            alert("O campo [Numero] é obrigatório!");
            return false;
        }
        if(!bairro){
            alert("O campo [Bairro] é obrigatório!");
            return false;
        }
        if(!cidade){
            alert("O campo [Cidade] é obrigatório!");
            return false;
        }
        if(!nrCep){
            alert("O campo [CEP] é obrigatório!");
            return false;
        }
        
        $.ajax({
            url:'<?=base_url()?>index.php/usuarios/alterarEndereco',
            method: 'post',
            data: {
                    logradouro : logradouro,
                    numero     : numero,
                    complemento: complemento,
                    bairro     : bairro,
                    cidade     : cidade,
                    nrCep      : nrCep,
                    indice     : indice
                  },
            dataType: 'json',
            success: function(response){
                $("#tdTableEnderecos").html(response.lista);
            }
        });
    }
</script>