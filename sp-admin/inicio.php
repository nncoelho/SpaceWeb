<?php 
    //========================================
    // Inicio
    //========================================

    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    }    
?>

<div class="container-fluid pad-20">

    <!-- Botão para aceder ao Setup -->
    <div class="text-center">
        <a href="?a=setup" class="btn btn-secondary">Setup</a>
    </div>
</div>