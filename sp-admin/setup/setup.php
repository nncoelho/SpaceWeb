<?php 
    //=========================================
    // AREA DO SETUP
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    } 
    
    // VERIFICA SE A VARIÁVEL 'a' ESTÁ DEFINIDA NA URL
    $a = '';
    if(isset($_GET['a'])){
        $a = $_GET['a'];
    }

    // ROUTE DO SETUP
    switch ($a) {

        // EXECUTA OS PROCEDIMENTOS PARA A CRIAÇÃO DA BASE DE DADOS
        case 'setup_criar_bd':        
            include('setup/setup_criar_bd.php');
            break;
        
        // INSERIR UTILIZADORES
        case 'setup_inserir_utilizadores':
            include('setup/setup_inserir_utilizadores.php');
            break;
    }
?>

<div class="container-fluid p-3">

    <h2 class="text-center">Setup</h2>

    <div class="text-center">
        <!-- CRIAR A BASE DE DADOS -->
        <p><a href="?a=setup_criar_bd" class="btn btn-primary btn-size-250">Criar a Base de Dados</a></p>
        <!-- INSERIR UTILIZADORES -->
        <p><a href="?a=setup_inserir_utilizadores" class="btn btn-success btn-size-250">Inserir Utilizadores</a></p>
        <hr>
        <p><a href="?a=home" class="btn btn-secondary btn-size-150">Voltar</a></p>
    </div>  

</div>