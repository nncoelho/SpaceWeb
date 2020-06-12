<?php 
    //=========================================
    // ROUTES DO BACKEND
    //=========================================

    // VERIFICAR A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }

    $a = 'inicio';
    if(isset($_GET['a'])){
        $a = $_GET['a'];
    }

    // VERIFICAR O LOGIN
    if(!funcoes::VerificarLogin()){
        
        // CASOS ESPECIAIS
        $routes_especiais = [
            'recuperar_password',
            'setup',
            'setup_criar_bd',
            'setup_inserir_utilizadores'
        ];

        // BYPASS DO SISTEMA NORMAL
        if(!in_array($a, $routes_especiais)){
            $a='login';
        }                        
    }

    //=========================================
    // ROUTES
    //=========================================
    switch ($a) {

        //=====================================
        // LOGIN
        case 'login':                           include_once('users/login.php'); break;
        // LOGOUT
        case 'logout':                          include_once('users/logout.php'); break;
        // RECUPERAR PASSWORD
        case 'recuperar_password':              include_once('users/recuperar_password.php'); break;

        //=====================================
        // PERFIL
        case 'perfil':                          include_once('users/perfil/perfil_menu.php'); break;
        // ALTERAR PASSWORD
        case 'perfil_alterar_password':         include_once('users/perfil/perfil_alterar_password.php'); break;
        // ALTERAR E-MAIL
        case 'perfil_alterar_email':            include_once('users/perfil/perfil_alterar_email.php'); break;
        
        //=====================================
        // OPÇÕES DISPONVEIS APENAS PARA O ADMINISTRADOR
        case 'utilizadores_gerir':              include_once('admin/utilizadores_gerir.php'); break;
        // ADICIONAR NOVO UTILIZADOR
        case 'utilizadores_adicionar':          include_once('admin/utilizadores_adicionar.php'); break;
        // EDITAR UTILIZADOR
        case 'editar_utilizador':               include_once('admin/utilizadores_editar.php'); break;
        // EDITAR PERMISSÕES
        case 'editar_permissoes':               include_once('admin/utilizadores_permissoes_editar.php'); break;
        // ELIMINAR UTILIZADOR
        case 'eliminar_utilizador':             include_once('admin/utilizadores_eliminar.php'); break;

        //=====================================
        // APRESENTA A PÁGINA INICIAL
        case 'inicio':                          include_once('inicio.php'); break;
        // APRESENTA A PÁGINA ACERCA DE
        case 'about':                           include_once('about.php'); break;
        // ABRE O MENU DO SETUP
        case 'setup':                           include_once('setup/setup.php'); break;

        //=====================================
        // SETUP - CRIAR A BASE DE DADOS
        case 'setup_criar_bd':                  include_once('setup/setup.php'); break;
        // SETUP - INSERIR UTILIZADORES
        case 'setup_inserir_utilizadores':      include_once('setup/setup.php'); break;
    }
    
?>