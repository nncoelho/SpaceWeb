<?php 
    //=========================================
    // INICIO DO BACKEND
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }    
?>

<div class="container-fluid pad-20">

    <!-- BOTÃO PARA ACEDER AO SETUP -->
    <div class="text-center mt-5">
        <a href="?a=setup" class="btn btn-primary btn-lg"><i class="fa fa-database"></i>&nbsp;&nbsp; Setup da Base de Dados</a>
    </div>

    <div class="text-center mt-5">
        <a href="http://spaceweb.me/?a=home" class="btn btn-secondary btn-size-150">Voltar</a>
    </div>
</div>