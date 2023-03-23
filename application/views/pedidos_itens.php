<fieldset class="border p-2"  id="tdTablePedidosItens">
<legend class="float-none w-auto">Detalhes do Pedido</legend>
<div class="form-group">
    <label for="txDescricao">Produto</label>
    <select class="form-select" aria-label="Default select example" id="idProduto" name="idProduto">
        <option selected>Selecione</option>
        <?php foreach($arProdutos as $idProduto=>$nmProduto){ ?>
            <option value="<?=$idProduto;?>"><?=$nmProduto;?></option>
        <?php } ?>
    </select>
</div>
<div class="row">
    <div class="col-4">
        <label for="txDescricao">Quantidade</label>
        <input type="numeric" class="form-control" value="0" id="qtItem" name="qtItem"  placeholder="Digite uma quantidade">
    </div>
    <div class="col-4">
        <label for="txDescricao">Valor</label>
        <input type="numeric" class="form-control" value="0,00" id="vlItem" name="vlItem"  placeholder="Digite um valor">
    </div>
</div><br>
<div class="row">
    <div class="col-5">&nbsp;</div>
    <div class="col-4">
        <button type="button" class="btn btn-light" id='btnIncluir' name='btnIncluir' onclick='incluirPedidoItem();'>Incluir Item</button>
        <button style='display:none' type="button" class="btn btn-light" id='btnAlterar' name='btnAlterar' onclick='alterarPedidoItem();'>Alterar Item</button>
    </div>
</div><br>
<div class="row">
    <table class="table table-striped table-bordered text-center" id='tablePedidosItens' name='tablePedidosItens'>
        <thead class="thead-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col">PRODUTO</th>
            <th scope="col">QUANTIDADE</th>
            <th scope="col">VALOR</th>
            <th scope="col">EDITAR</th>
            <th scope="col">EXCLUIR</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!is_array($coItensPedidos)){
                $coItensPedidos = unserialize($this->session->userdata('coItensPedidos'));
            }
            if(count($coItensPedidos) > 0){
                foreach($coItensPedidos as $indice=>$pedido_item){?>
                <tr>
                <th scope="row"><input type='hidden' id='indice' name='indice'><?php echo $indice+1;?></th>
                <td><?php $obProduto = new Produtos_model();
                        $obProduto = $obProduto->lerPorId($pedido_item->id_produto);
                           echo $obProduto->nm_produto; ?></td>
                <td><?php echo $pedido_item->qt_item;?></td>
                <td><?php echo number_format($pedido_item->vl_item, 2, ',', '.');?></td>
                <td><a href="javascript:carregarPedidoItem(<?=$indice;?>);" id='editar_<?php echo $pedido_item->id_pedido_item;?>' title='Editar' ><i class="bi bi-pen-fill"></i></a></td>
                <td><a href="" data-bs-toggle="modal" data-bs-target="#modalExcluir" id='excluir' title='Excluir' ><i class="bi bi-x-square-fill"></i></a></td>
                <div class="modal" tabindex="-1" id="modalExcluir" name='modalExcluir'>
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Excluir Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <p>Deseja mesmo excluir esse endereço?</p>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="excluirPedidoItem('<?=$indice?>');">Sim</button>
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
    function incluirPedidoItem(){
        var idProduto  = $("#idProduto").val();
        var qtItem     = $("#qtItem").val();
        var vlItem     = $("#vlItem").val();

        if(!idProduto){
            alert("O campo [Produto] é obrigatório!");
            return false;
        }
        if(!qtItem){
            alert("O campo [Quantidade] é obrigatório!");
            return false;
        }
        if(!vlItem){
            alert("O campo [Valor] é obrigatório!");
            return false;
        }
        $.ajax({
            url:'<?=base_url()?>index.php/pedidos/incluirPedidoItem',
            method: 'post',
            data: {
                    idProduto : idProduto,
                    qtItem    : qtItem,
                    vlItem    : vlItem
                  },
            dataType: 'json',
            success: function(response){
                $("#tdTablePedidosItens").html(response.lista);
                calcularValorTotalPedido();
            }
        });
    }

    function excluirPedidoItem(indice){
        $.ajax({
            url:'<?=base_url()?>index.php/pedidos/excluirPedidoItem',
            method: 'post',
            data: {
                    indice : indice
                  },
            dataType: 'json',
            success: function(response){
                    $("#tdTablePedidosItens").html(response.lista);
                $(".modal-backdrop").hide();
                $("body").removeClass();
                $("body").removeAttr('style');
                calcularValorTotalPedido();
            }
        });
    }

    function carregarPedidoItem($indice){
        $.ajax({
            url:'<?=base_url()?>index.php/pedidos/carregarPedidoItem',
            method: 'post',
            data: {
                    indice : $indice
                  },
            dataType: 'json',
            success: function(response){
                $("#indice").val(response.indice);
                document.getElementById("idProduto").selectedIndex = response.idProduto;
                $("#qtItem").val(response.qtItem);
                $("#vlItem").val(response.vlItem);
                
                $("#btnIncluir").attr("style","display:none");
                $("#btnAlterar").removeAttr("style");

            }
        });
    }

    function alterarPedidoItem(){
        var idProduto  = $("#idProduto").val();
        var qtItem     = $("#qtItem").val();
        var vlItem     = $("#vlItem").val();
        var indice     = $("#indice").val();

        if(!idProduto){
            alert("O campo [Produto] é obrigatório!");
            return false;
        }
        if(!qtItem){
            alert("O campo [Quantidade] é obrigatório!");
            return false;
        }
        if(!vlItem){
            alert("O campo [Valor] é obrigatório!");
            return false;
        }
        
        $.ajax({
            url:'<?=base_url()?>index.php/pedidos/alterarPedidoItem',
            method: 'post',
            data: {
                    idProduto  : idProduto,
                    qtItem     : qtItem,
                    vlItem     : vlItem,
                    indice     : indice
                  },
            dataType: 'json',
            success: function(response){
                $("#tdTablePedidosItens").html(response.lista);
                calcularValorTotalPedido();
            }
        });
    }
    calcularValorTotalPedido();
    function calcularValorTotalPedido(){
        $.ajax({
            url:'<?=base_url()?>index.php/pedidos/calcularValorTotalPedido',
            method: 'post',
            data: {},
            dataType: 'json',
            success: function(response){
                $("#vlTotal").val(response.vlTotal);
            }
        });
    }
</script>