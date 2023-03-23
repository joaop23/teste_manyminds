<?php if(count($coLog) > 0){
    foreach($coLog as $indice=>$obLog){
        $obUsuario = new Usuarios_model();
        $obUsuario = $obUsuario->lerPorId($obLog->id_usuario);?>
    <tr>
        <th scope="row"><?php echo $indice+1;?></th>
        <th scope="row"><?php echo $obLog->dt_alteracao;?></th>
        <th scope="row"><?php echo ($obLog->operacao == 'I' ? 'Inserção' : 'Alteração');?></th>
        <th scope="row"><?php echo $obUsuario->nome;?></th>
        <th scope="row"><?php echo $obLog->nr_ip;?></th>
    </tr>
    <?php } } ?>