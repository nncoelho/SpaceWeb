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
    <div class="text-center">
        <a href="?a=setup" class="btn btn-secondary">Setup</a>
    </div>
</div>