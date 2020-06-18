<?php
    //========================================
    // SEM PERMISSÃO
    //========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }

    // VERIFICA PERMISSÃO DE ADMINISTRADOR
    $erro_permissao = false;
    if(!funcoes::Permissao(0)){
        $erro_permissao = true;
    }
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6 card m-5 p-4">        
            <div class="text-center">
                <h1><i class="fa fa-exclamation-triangle" style="color: red"></i></h1>
                <p>Não tem permissão para esta funcionalidade.</p>
                <a href="?a=inicio" class="btn btn-primary btn-size-150">Voltar</a>
            </div>  
        </div>      
    </div>
</div>