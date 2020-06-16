<?php 
    //=========================================
    // INICIO DO BACKEND
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }    
?>
<div class="container pad-20">
    <div class="row mt-4 mb-3 p-3">
        <div class="col-md-8 offset-md-2 card"> 
            <?php if(funcoes::Permissao(0)): ?>
                <!-- BOTÃO PARA ACEDER AO SETUP -->
                <div class="text-center mt-5">
                    <h3><i class="fa fa-database" style="color: green;"></i> Administração da Base de Dados</h3>
                    <a href="?a=setup" class="btn btn-primary btn-lg btn-size-300 mt-5">Setup da Base de Dados</a><br>
                    <a href="http://spaceweb.me/?a=home" class="btn btn-secondary btn-size-150 mb-5 mt-5">Voltar</a>
                </div>
            <?php else: ?>
                <div class="text-center mt-5">
                    <h3 class="mb-4">Área Reservada a Administradores</h3>
                    <h1><i class="fa fa-ban mb-3" style="color: red;" aria-hidden="true"></i></h1>
                    <a href="http://spaceweb.me/?a=home" class="btn btn-secondary btn-size-150 mb-5">Voltar</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>