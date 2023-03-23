<div class="row justify-content-center" >
    <div class="col-sm-2 col-md-2 col-lg-2"></div>
    <div class="col-md-7 col-lg-7 pull-left">
        <center>
            <h2>Teste Desenvolvimento PHP - Many Minds</h2>
            
        </center>
    </div>
    <div class="col-md-3 col-lg-3 pull-right text-left user-login">
        <a href="#" class="dropdown-toggle" id="dropdownMenu1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="bi bi-person-circle"></span> <?php echo $nomeUsuario; ?><span class="caret"></span>
        </a>
        
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li role="separator" class="divider"></li>
            <li><a href="<?php echo base_url('index.php/Login/logout'); ?>" class="dropdown-item">Sair do Sistema</a></li>
        </ul>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo base_url(''); ?>">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cadastros
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php foreach($arMenu as $arDados){ ?>
                            <li><a class="dropdown-item" href="<?php echo isset($arDados->url) ? $arDados->url : '' ;?>"><?php echo $arDados->nm_programa;?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>