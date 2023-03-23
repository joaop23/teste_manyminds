<?php $this->load->view('pagina_inicio'); ?>
<?php $this->load->view('header'); ?>
<div class="menuItens">
	<?php 
		foreach($arMenu as $arDados){  ?>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 progMenu">
					<a href="<?php echo (isset($arDados->url) ? $arDados->url : '#');?>">
						<div class="menu-item">
							<div class="menu-item-ico">
								<i class="bi <?php echo $arDados->icone; ?> item-ico" ></i>
							</div>
							<div class="menu-item-title"><?php echo $arDados->nm_programa; ?></div>
						</div>
					</a>
				</div>
				<?php 
		} ?>
</div>
<?php $this->load->view('footer'); ?>
<?php $this->load->view('pagina_fim'); ?>

