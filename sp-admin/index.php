<?php
    //========================================
    // Index do Backend
    //========================================    
    
    // Controlo de Sessão
    session_start();
    if(!isset($_SESSION['a'])){
        $_SESSION['a'] = 'inicio';
    }

    // Inclui as funcoes necessárias do Sistema 
    include_once('../inc/funcoes.php');

    include_once('../inc/cl_datas.php');

    include_once('../inc/emails.php');

    include_once('../inc/gestorBD.php');    

    // Barra do Utilizador
    include_once('users/barra_utilizador.php');

    include_once('_cabecalho.php');   

    include_once('routes.php');
    
    include_once('_rodape.php');

?>