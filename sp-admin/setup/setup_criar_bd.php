<?php 
    //========================================
    // Setup - Criar a Base de Dados
    //========================================

    // Verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    } 

    // Cria a Base de Dados
    $gestor = new cl_gestorBD();        
    $configs = include('../inc/config.php');

    // Apagar a Base de Dados caso ela exista
    $gestor->EXE_NON_QUERY('DROP DATABASE IF EXISTS '.$configs['BD_DATABASE']);
    
    // Cria a Nova Base de Dados
    $gestor->EXE_NON_QUERY('CREATE DATABASE '.$configs['BD_DATABASE'].' CHARACTER SET UTF8 COLLATE utf8_general_ci');
    $gestor->EXE_NON_QUERY('USE '.$configs['BD_DATABASE']);

    //=============================================
    // Criação das Tabelas
    //=============================================

    //==========================
    // Utilizadores
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE utilizadores('.
        'id_utilizador                  INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'utilizador                     NVARCHAR(50), '.
        'palavra_passe                  NVARCHAR(200), '.
        'nome                           NVARCHAR(50), '.
        'email                          NVARCHAR(50), '.
        'permissoes                     NVARCHAR(100), '.
        'criado_em                      DATETIME, '.
        'atualizado_em                  DATETIME)'
    );

    //==========================
    // Logs
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE logs('.
        'id_log                         INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'data_hora                      DATETIME, '.
        'utilizador                     NVARCHAR(50), '.
        'mensagem                       NVARCHAR(200))'
    );

    //==========================
    // Clientes
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE clientes('.
        'id_cliente                     INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'nome                           NVARCHAR(50), '.
        'email                          NVARCHAR(50), '.
        'utilizador                     NVARCHAR(50), '.
        'palavra_passe                  NVARCHAR(200), '.        
        'codigo_validacao               NVARCHAR(200), '.   
        'validada                       TINYINT, '.
        'criado_em                      DATETIME, '.
        'atualizado_em                  DATETIME)'
    );
?>

<div class="alert alert-success text-center">Base de Dados Criada com Sucesso.</div>