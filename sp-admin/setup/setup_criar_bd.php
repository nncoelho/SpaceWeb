<?php 
    //=========================================
    // SETUP/ADMIN - CRIAR A BASE DE DADOS
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    } 

    // CRIA A BASE DE DADOS
    $gestor = new Gestor();

    // APAGA A BASE DE DADOS CASO ELA EXISTA
    // $gestor->EXE_NON_QUERY('DROP DATABASE IF EXISTS '.$results['db_name']);
    
    // CRIA A NOVA BASE DE DADOS
    // $gestor->EXE_NON_QUERY('CREATE DATABASE '.$results['db_name'].' CHARACTER SET UTF8 COLLATE utf8_general_ci');
    // $gestor->EXE_NON_QUERY('USE '.$results['db_name']);

    //=========================================
    // CRIAÇÃO DAS TABELAS
    //=========================================

    //==========================
    // UTILIZADORES
    //==========================
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
    // LOGS
    //==========================
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE logs('.
        'id_log                         INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'data_hora                      DATETIME, '.
        'utilizador                     NVARCHAR(50), '.
        'mensagem                       NVARCHAR(200))'
    );

    //==========================
    // CLIENTES
    //==========================
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

<div class="alert alert-success offset-3 col-6 mt-2 text-center">Base de Dados Criada com Sucesso.</div>