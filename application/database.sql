CREATE TABLE `usuarios` (
    `id_usuario` INT(7) NOT NULL AUTO_INCREMENT,
    `cs_ativo` varchar(1) NOT NULL,
    `nome` varchar(250) NOT NULL,
    `senha` varchar(100) NOT NULL,
    `email` varchar(45) NOT NULL,
    `nr_cgc` varchar(14) NOT NULL UNIQUE,
    `cs_pessoa` varchar(1) NOT NULL,
    `id_perfil` INT(7) NOT NULL,
    PRIMARY KEY (`id_usuario`)
);
ALTER TABLE `usuarios` ADD CONSTRAINT `usuarios_perfil_fk0` FOREIGN KEY (`id_perfil`) REFERENCES `perfis`(`id_perfil`);


CREATE TABLE `pedidos` (
    `id_pedido` INT(7) NOT NULL AUTO_INCREMENT,
    `id_usuario` INT(7) NOT NULL,
    `cd_pedido` varchar(15)  NOT NULL,
    `observacao` TEXT NOT NULL,
    `cs_status` varchar(1) NOT NULL,
    `vl_total` DECIMAL NOT NULL,
    PRIMARY KEY (`id_pedido`)
);
ALTER TABLE `pedidos` ADD CONSTRAINT `pedidos_fk0` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id_usuario`);

CREATE TABLE `produtos` (
    `id_produto` INT(7) NOT NULL AUTO_INCREMENT,
    `cs_ativo` varchar(1) NOT NULL,
    `nm_produto` varchar(250) NOT NULL,
    `cd_produto` varchar(15) NOT NULL,
    PRIMARY KEY (`id_produto`)
);

CREATE TABLE `perfis` (
    `id_perfil` INT(7) NOT NULL AUTO_INCREMENT,
    `nm_perfil` varchar(100) NOT NULL,
    `cs_perfil` varchar(1) NOT NULL,
    PRIMARY KEY (`id_perfil`)
);
INSERT INTO `perfis` (`id_perfil`, `nm_perfil`, `cs_perfil`) VALUES ('1','Fornecedor','F');
INSERT INTO `perfis` (`id_perfil`, `nm_perfil`, `cs_perfil`) VALUES ('2','Cliente','C');

CREATE TABLE `enderecos` (
    `id_endereco` INT(7) NOT NULL AUTO_INCREMENT,
    `logradouro` varchar(250) NOT NULL,
    `numero` varchar(10) NOT NULL,
    `complemento` varchar(100) NOT NULL,
    `nm_bairro` varchar(150) NOT NULL,
    `nm_cidade` varchar(150) NOT NULL,
    `nr_cep` varchar(8) NOT NULL,
    `id_usuario` INT(7) NOT NULL,
    PRIMARY KEY (`id_endereco`)
);
ALTER TABLE `enderecos` ADD CONSTRAINT `enderecos_fk0` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id_usuario`);

CREATE TABLE `menu` (
    `id_menu` INT(7) NOT NULL AUTO_INCREMENT,
    `nm_programa` varchar(250) NOT NULL,
    `icone` varchar(200) NOT NULL,
    `url` varchar(250) NOT NULL,
    PRIMARY KEY (`id_menu`)
);

INSERT INTO `menu` (`id_menu`, `nm_programa`, `icone`, `url`) VALUES ('1','Cadastro de Usuarios','bi-person-bounding-box','index.php/usuarios');
INSERT INTO `menu` (`id_menu`, `nm_programa`, `icone`, `url`) VALUES ('2','Cadastro de Produtos','bi-gift-fill','index.php/produtos');
INSERT INTO `menu` (`id_menu`, `nm_programa`, `icone`, `url`) VALUES ('3','Cadastro de Pedidos','bi-cart','index.php/pedidos');
CREATE TABLE `permissao_acesso` (
    `id_permissao_acesso` INT(7) NOT NULL AUTO_INCREMENT,
    `cs_permissao` varchar(1) NOT NULL,
    `id_perfil` INT(7) NOT NULL,
    `id_menu` INT(7) NOT NULL,
    PRIMARY KEY (`id_permissao_acesso`)
);
ALTER TABLE `permissao_acesso` ADD CONSTRAINT `permissao_acesso_fk0` FOREIGN KEY (`id_perfil`) REFERENCES `perfis`(`id_perfil`);
ALTER TABLE `permissao_acesso` ADD CONSTRAINT `permissao_acesso_fk1` FOREIGN KEY (`id_menu`) REFERENCES `menu`(`id_menu`);
INSERT INTO `permissao_acesso` (`id_permissao_acesso`, `cs_permissao`, `id_perfil`, `id_menu`) VALUES ('1','1','1','1');
INSERT INTO `permissao_acesso` (`id_permissao_acesso`, `cs_permissao`, id_perfil, `id_menu`) VALUES ('2','1','2','1');
INSERT INTO `permissao_acesso` (`id_permissao_acesso`, `cs_permissao`, id_perfil, `id_menu`) VALUES ('3','1','2','2');
INSERT INTO `permissao_acesso` (`id_permissao_acesso`, `cs_permissao`, id_perfil, `id_menu`) VALUES ('4','1','2','3');
CREATE TABLE `ca_login` (
    `id_ca_login` INT(7) NOT NULL AUTO_INCREMENT,
    `nr_ip` varchar(20) NOT NULL,
    `qtd_tentativa` INT(1) NOT NULL,
    `dt_tentativa` DATETIME NOT NULL,
	
    PRIMARY KEY (`id_ca_login`)
);

CREATE TABLE `ca_login_trava` (
    `id_login_trava` INT(7) NOT NULL AUTO_INCREMENT,
    `dt_bloqueio` DATETIME NOT NULL,
    `dt_desbloqueio` DATETIME NOT NULL,
    `id_ca_login` INT(7) NOT NULL,
    PRIMARY KEY (`id_login_trava`)
);
ALTER TABLE `ca_login_trava` ADD CONSTRAINT `ca_login_trava_fk0` FOREIGN KEY (`id_ca_login`) REFERENCES `ca_login`(`id_ca_login`);

CREATE TABLE `pedidos_itens` (
    `id_pedido_item` INT(7) NOT NULL AUTO_INCREMENT,
    `id_pedido` INT(7) NOT NULL,
    `id_produto` INT(7) NOT NULL,
    `qt_item` INT(5) NOT NULL,
    `vl_item` FLOAT NOT NULL,
    PRIMARY KEY (`id_pedido_item`)
);
ALTER TABLE `pedidos_itens` ADD CONSTRAINT `pedidos_itens_fk0` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos`(`id_pedido`);
ALTER TABLE `pedidos_itens` ADD CONSTRAINT `pedidos_itens_fk1` FOREIGN KEY (`id_produto`) REFERENCES `produtos`(`id_produto`);

CREATE TABLE `log` (
    `id_log` INT(7) NOT NULL AUTO_INCREMENT,
    `dt_alteracao` TIMESTAMP NOT NULL,
    `tabela` varchar(255) NOT NULL,
    `id_alterado` varchar(18) NOT NULL,
    `operacao` varchar(1) NOT NULL,
    `nr_ip` varchar(20) NOT NULL,
    `id_usuario` INT(7) NOT NULL,
    PRIMARY KEY (`id_log`)
);
ALTER TABLE `log` ADD CONSTRAINT `log_fk0` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id_usuario`);

CREATE TABLE `detalhe_log` (
    `id_detalhe_log` INT(7) NOT NULL AUTO_INCREMENT,
    `id_log` INT(7) NOT NULL,
    `atributo` varchar(35) NOT NULL,
    `valor` varchar(2000),
    `valor_novo` varchar(2000),
    PRIMARY KEY (`id_detalhe_log`)
);
ALTER TABLE `detalhe_log` ADD CONSTRAINT `detalhe_log_fk0` FOREIGN KEY (`id_log`) REFERENCES `log`(`id_log`);







