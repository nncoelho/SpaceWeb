<?php
//=========================================
// ROUTES DO BACKEND
//=========================================

// VERIFICAR A SESSÃO
if (!isset($_SESSION['a'])) {
    exit();
}

$a = 'inicio';
if (isset($_GET['a'])) {
    $a = $_GET['a'];
}

// VERIFICAR O LOGIN
if (!funcoes::VerificarLogin()) {

    // CASOS ESPECIAIS
    $routes_especiais = [
        'recuperar_password',
        'setup_criar_bd',
        'setup_inserir_clientes',
        'setup_inserir_utilizadores',
        'setup'
    ];

    // BYPASS DO SISTEMA NORMAL
    if (!in_array($a, $routes_especiais)) {
        $a = 'login';
        $routes_especiais;
    }
}

//=========================================
// ROUTES - SWITCH
//=========================================
switch ($a) {

        //=====================================
        // LOGIN DOS UTILIZADORES/ADMIN
    case 'login':
        include_once('users/login.php');
        break;
        // LOGOUT
    case 'logout':
        include_once('users/logout.php');
        break;
        // RECUPERAR PASSWORD
    case 'recuperar_password':
        include_once('users/recuperar_password.php');
        break;

        //=====================================
        // PERFIL DOS UTILIZADORES
    case 'perfil':
        include_once('users/perfil/perfil_menu.php');
        break;
        // ALTERAR PASSWORD
    case 'perfil_alterar_password':
        include_once('users/perfil/perfil_alterar_password.php');
        break;
        // ALTERAR E-MAIL
    case 'perfil_alterar_email':
        include_once('users/perfil/perfil_alterar_email.php');
        break;

        //=====================================
        // OPÇÕES DISPONVEIS APENAS PARA OS ADMINISTRADORES
    case 'utilizadores_gerir':
        include_once('admin/utilizadores_gerir.php');
        break;
        // ADICIONAR NOVO UTILIZADOR
    case 'utilizadores_adicionar':
        include_once('admin/utilizadores_adicionar.php');
        break;
        // EDITAR UTILIZADOR
    case 'editar_utilizador':
        include_once('admin/utilizadores_editar.php');
        break;
        // EDITAR PERMISSÕES
    case 'editar_permissoes':
        include_once('admin/utilizadores_permissoes_editar.php');
        break;
        // ELIMINAR UTILIZADOR
    case 'eliminar_utilizador':
        include_once('admin/utilizadores_eliminar.php');
        break;

        //=====================================
        // PÁGINA INICIAL DO BACKEND
    case 'inicio':
        include_once('inicio.php');
        break;
        // PÁGINA DO ABOUT
    case 'about':
        include_once('about.php');
        break;

        //=====================================
        // SETUP DA BASE DE DADOS
    case 'setup':
        include_once('setup/setup.php');
        break;
        // LIMPA E CONSTROI A BASE DE DADOS
    case 'setup_criar_bd':
        include_once('setup/setup.php');
        break;
        // INSERIR UTILIZADORES
    case 'setup_inserir_utilizadores':
        include_once('setup/setup.php');
        break;
        // INSERIR CLIENTES
    case 'setup_inserir_clientes':
        include_once('setup/setup.php');
        break;

        //=====================================
        // CLIENTES
    case 'clientes_lista':
        include_once('clientes/clientes_lista.php');
        break;
        // VISUALIZACAO DOS DADOS DO CLIENTE
    case 'clientes_dados':
        include_once('clientes/clientes_dados.php');
        break;
        // ELIMINAR CLIENTE
    case 'clientes_eliminar':
        include_once('clientes/clientes_eliminar.php');
        break;
}
