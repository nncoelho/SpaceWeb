<?php 
    //=========================================
    // Routes do Backend
    //=========================================

    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    $a = 'inicio';
    if(isset($_GET['a'])){
        $a = $_GET['a'];
    }

    // Verificar o Login
    if(!funcoes::VerificarLogin()){
        
        // Casos especiais
        $routes_especiais = [
            'recuperar_password',
            'setup',
            'setup_criar_bd',
            'setup_inserir_utilizadores'
        ];

        // Bypass do Sistema Normal
        if(!in_array($a, $routes_especiais)){
            $a='login';
        }                        
    }

    //=========================================
    // Routes
    //=========================================
    switch ($a) {

        //=====================================
        // Login
        case 'login':                           include_once('users/login.php'); break;
        // Logout
        case 'logout':                          include_once('users/logout.php'); break;
        // Recuperar Password
        case 'recuperar_password':              include_once('users/recuperar_password.php'); break;

        //=====================================
        // Perfil
        case 'perfil':                          include_once('users/perfil/perfil_menu.php'); break;
        // Alterar Password
        case 'perfil_alterar_password':         include_once('users/perfil/perfil_alterar_password.php'); break;
        // Alterar Email
        case 'perfil_alterar_email':            include_once('users/perfil/perfil_alterar_email.php'); break;
        
        //=====================================
        // Opções do Administrador
        case 'utilizadores_gerir':              include_once('admin/utilizadores_gerir.php'); break;
        // Formulário para adicionar Novo Utilizador
        case 'utilizadores_adicionar':          include_once('admin/utilizadores_adicionar.php'); break;
        // Editar Utilizador
        case 'editar_utilizador':               include_once('admin/utilizadores_editar.php'); break;
        // Editar Permissões
        case 'editar_permissoes':               include_once('admin/utilizadores_permissoes_editar.php'); break;
        // Eliminar Utilizador
        case 'eliminar_utilizador':             include_once('admin/utilizadores_eliminar.php'); break;

        //=====================================
        // Apresentar a Página Inicial
        case 'inicio':                          include_once('inicio.php'); break;
        // Apresenta a Página Acerca de
        case 'about':                           include_once('about.php'); break;
        // Abre o menu do Setup
        case 'setup':                           include_once('setup/setup.php'); break;

        //=====================================
        // Setup - Criar a Base de Dados
        case 'setup_criar_bd':                  include_once('setup/setup.php'); break;
        // Setup - Inserir Utilizadores
        case 'setup_inserir_utilizadores':      include_once('setup/setup.php'); break;
    }
    
?>