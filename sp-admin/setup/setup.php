<?php 
    //=========================================
    // ÁREA DO SETUP
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    } 
    
    // VERIFICA SE A VARIÁVEL 'A' ESTÁ DEFINIDA NA URL
    $a = '';
    if(isset($_GET['a'])){
        $a = $_GET['a'];
    }

    // ROUTE DO SETUP
    switch ($a) {

        // EXECUTA OS PROCEDIMENTOS PARA A CRIAÇÃO DA BASE DE DADOS
        case 'setup_criar_bd':
            include('setup_criar_bd.php');
            break;
        
        // INSERIR UTILIZADORES
        case 'setup_inserir_utilizadores':
            include('setup_inserir_utilizadores.php');
            break;
    }
?>

<div class="container-fluid p-3">

    <h2 class="text-center mb-4">Setup</h2>

    <div class="text-center">
        <!-- CRIAR A BASE DE DADOS -->
        <p><a href="?a=setup_criar_bd" class="btn btn-primary btn-size-250">
            <i class="fa fa-table fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Criar a Base de Dados</a>
        </p>
        <!-- INSERIR UTILIZADORES -->
        <p><a href="?a=setup_inserir_utilizadores" class="btn btn-success btn-size-250">
            <i class="fa fa-user-plus fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Inserir Utilizadores</a></p>
        <hr class="mt-5">
        <p><a href="http://spaceweb.me/sp-admin/" class="btn btn-secondary mt-3 btn-size-150">Voltar</a></p>
    </div>  

</div>