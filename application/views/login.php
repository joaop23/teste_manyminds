<link rel="stylesheet" href="<?php echo base_url("assets/css/login.css");?>">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<div class="container">
    <div class="content first-content">
            <div class="first-column">
                <h2 class="title title-primary">Olá!</h2>
                <p class="description description-primary">Não tem uma conta?</p>
                <p class="description description-primary">Faça seu cadastro e aproveite!</p>
                <button id="signin" class="btn btn-primary">Cadastre-se</button>
            </div>
            <div class="second-column">
                <?php if(isset($erro)){ ?> 
                    <div class="alert alert-danger" role="alert">
                        <?php echo $erro;?>
                    </div>
                <?php } ?>
                <h3 class="title-second text-justify">Seja bem vindo(a) ao</h3><h2 class="title-second text-justify"> Teste da Many Minds</h2>
                <p class="description description-second">Digite seus dados abaixo para acessar:</p>
                <form class="form" id="formLogin" method="POST" action="<?php echo base_url('index.php/login/logar');?>">
                
                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <input id="nmEmail" name="nmEmail" type="email" placeholder="Email">
                    </label>
                
                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modify"></i>
                        <input id="teSenha" name="teSenha" type="password" placeholder="Password">
                    </label>
                
                    <button class="btn btn-second">Entrar</button>
                </form>
            </div>
        </div>
        <div class="content second-content">
            <div class="first-column">
                <h2 class="title title-primary">Olá!</h2>
                <p class="description description-primary">Para manter-se conectado,</p>
                <p class="description description-primary">Faça o login com suas informações pessoais.</p>
                <button id="signup" class="btn btn-primary">Entrar</button>
            </div>    
            <div class="second-column">
                <!--<h2 class=" title-second">Cadastre-se</h2>-->
                
                <form class="form" id="formCadastro" method="POST" action="<?php echo base_url("index.php/login/cadastrar") ?>">
                        <label class="label-input" for="">
                            <i class="far fa-user icon-modify"></i>
                            <input type="text" id="nome" name="nome" placeholder="Nome">
                        </label>
                        
                        <label class="label-input" for="">
                            <i class="far fa-envelope icon-modify"></i>
                            <input type="email" id="email" name="email" placeholder="Email">
                        </label>
                        
                        <label class="label-input" for="">
                            <i class="fas fa-lock icon-modify"></i>
                            <input type="password" id="senha" name="senha" placeholder="Senha">
                        </label>

                        <label class="label-input" for="">
                            <i class="far fa-solid fa-id-card  icon-modify"></i>
                            <input type="nrCgc" id="nrCgc" name="nrCgc" placeholder="CPF/CNPJ">
                        </label>

                        <select class="form-select" id="idPerfil" name="idPerfil" aria-label="Selecione o perfil">
                            <?php foreach($arPerfis as $obPerfil){?>
                                <option value="<?=$obPerfil->id_perfil;?>"><?=$obPerfil->nm_perfil;?></option>
                            <?php } ?>
                        </select>
                    
                    <button class="btn btn-second">Cadastre-se</button>        
                </form>
            </div>
        </div>
        
    </div>
<script src="<?php echo base_url("assets/js/login.js");?>"></script>
<?php $this->load->view('pagina_fim'); ?>