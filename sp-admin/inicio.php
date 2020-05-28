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
        <a href="?a=setup" class="btn btn-primary btn-size-150">Setup da Base de Dados</a>
    </div>
</div>