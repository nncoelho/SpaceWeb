<?php 
    //=========================================
    // Setup
    //=========================================

    // Verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    } 
    
    // Verifica se 'a' está definido na URL
    $a = '';
    if(isset($_GET['a'])){
        $a = $_GET['a'];
    }

    // Route do Setup
    switch ($a) {
        case 'setup_criar_bd':        
            // Executa os procedimentos para a criação da Base de Dados
            include('setup/setup_criar_bd.php');
            break;
        
        case 'setup_inserir_utilizadores':
            // Inserir Utilizadores
            include('setup/setup_inserir_utilizadores.php');
            break;
    }
?>

<div class="container-fluid pad-20">
    <h2 class="text-center">Setup</h2>

    <div class="text-center">
        <!-- Criar a Base de Dados -->
        <p><a href="?a=setup_criar_bd" class="btn btn-secondary btn-size-250">Criar a Base de Dados</a></p>
        <!-- Inserir Utilizadores -->
        <p><a href="?a=setup_inserir_utilizadores" class="btn btn-secondary btn-size-250">Inserir Utilizadores</a></p>
        <hr>
        <p><a href="?a=inicio" class="btn btn-secondary btn-size-150">Voltar</a></p>
    </div>
</div>