<?php 
    //=========================================
    // SETUP - INSERIR UTILIZADORES
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    } 

    // ACESSO A BASE DE DADOS
    $gestor = new Gestor();

    // LIMPAR OS DADOS DOS UTILIZADORES
    $gestor->EXE_NON_QUERY('DELETE FROM utilizadores');
    $gestor->EXE_NON_QUERY('ALTER TABLE utilizadores AUTO_INCREMENT=1');

    $data = new DateTime();
    
    //==============================================================
    // UTILIZADOR 1 - ADMIN
    // DEFINIÇÃO DE PARAMETROS
    $parametros = [
        ':utilizador'       => 'Admin',
        ':palavra_passe'    => md5('admin'),
        ':nome'             => 'Administrador',
        ':email'            => 'nncoelho.dev@gmail.com',
        ':permissoes'       => str_repeat('1', 100),
        ':criado_em'        => $data->format('Y-m-d H:i:s'),
        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
    ];

    // INSERIR O UTILIZADOR
    $gestor->EXE_NON_QUERY(
        'INSERT INTO utilizadores(utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
         $parametros);

    //==============================================================
    // UTILIZADOR 2 - NUNO
    // DEFINIÇÃO DE PARAMETROS
    $parametros = [
        ':utilizador'       => 'Nuno',
        ':palavra_passe'    => md5('nuno'),
        ':nome'             => 'Nuno Coelho',
        ':email'            => 'nunocoelho@gmail.com',
        ':permissoes'       => str_repeat('1', 99),
        ':criado_em'        => $data->format('Y-m-d H:i:s'),
        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
    ];

    // INSERIR O UTILIZADOR
    $gestor->EXE_NON_QUERY(
        'INSERT INTO utilizadores(utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
         $parametros);

    //==============================================================
    // UTILIZADOR 3 - VERA
    // DEFINIÇÃO DE PARAMETROS
    $parametros = [
        ':utilizador'       => 'Vera',
        ':palavra_passe'    => md5('vera'),
        ':nome'             => 'Vera Matos',
        ':email'            => 'veramatos@gmail.com',
        ':permissoes'       => '0'.str_repeat('1', 99),
        ':criado_em'        => $data->format('Y-m-d H:i:s'),
        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
    ];

    // INSERIR O UTILIZADOR
    $gestor->EXE_NON_QUERY(
        'INSERT INTO utilizadores(utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
         $parametros);

    //==============================================================
    // UTILIZADOR 4 - JORGE
    // DEFINIÇÃO DE PARAMETROS
    $parametros = [
        ':utilizador'       => 'Jorge',
        ':palavra_passe'    => md5('jorge'),
        ':nome'             => 'Jorge Moita',
        ':email'            => 'jorgemoita@gmail.com',
        ':permissoes'       => '0'.str_repeat('1', 99),
        ':criado_em'        => $data->format('Y-m-d H:i:s'),
        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
    ];

    // INSERIR O UTILIZADOR
    $gestor->EXE_NON_QUERY(
        'INSERT INTO utilizadores(utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
         $parametros);
?>
<div class="alert alert-success offset-3 col-6 mt-2 text-center">Utilizadores inseridos com Sucesso.</div>