<?php 
    //========================================
    // ROUTES DA APLICAÇÃO WEB
    //========================================

    // VERIFICA A SESSÃO
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
        case 'home':                            include_once('inicio.php'); break;

        //========================================
        // CLIENTES
        //========================================

        // VALIDAR CONTA DE CLIENTE
        case 'validar':                         include_once('clientes/validar_cliente.php'); break;
        // LOGIN
        case 'login':                           include_once('clientes/login.php'); break;
        // SIGNUP
        case 'signup':                          include_once('clientes/signup.php'); break;
        // LOGOUT
        case 'logout':                          include_once('clientes/logout.php'); break;
        // PERFIL
        case 'perfil':                          include_once('clientes/perfil.php'); break;
    }
?>