<?php
    //========================================
    // SEM PERMISSÃO
    //========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6 card m-3 p-3">        
            <div class="text-center">
                <h1><i class="fa fa-exclamation-triangle" style="color: red"></i></h1>
                <p>Não tem Permissão para esta funcionalidade.</p>
                <a href="?a=inicio" class="btn btn-primary btn-size-150">Voltar</a>
            </div>  
        </div>      
    </div>
</div>