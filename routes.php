<?php 
    //========================================
    // Routes da Aplicação Web
    //========================================

    // Verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    $a = 'home';
    if(isset($_GET['a'])){
        $a = $_GET['a'];
    }    

    //========================================
    // ROUTES
    //========================================
    switch ($a) {

        // HOME
        case 'home':                            include_once('webgeral/index.php'); break;                

        //========================================
        // CLIENTES
        //========================================

        // Validar conta de cliente
        case 'validar':                         include_once('clientes/validar_cliente.php'); break;
        // Login
        case 'login':                           include_once('clientes/login.php'); break;
        // Signup
        case 'signup':                          include_once('clientes/signup.php'); break;
        // Logout        
        case 'logout':                          include_once('clientes/logout.php'); break;
        // Perfil 
        case 'perfil':                          include_once('clientes/perfil.php'); break;
    }
?>