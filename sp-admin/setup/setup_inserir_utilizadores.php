<?php 
    //========================================
    // Setup - Inserir Utilizadores
    //========================================

    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    } 

    // Inserir o Utilizador Admin
    $gestor = new cl_gestorBD();

    // Limpar os Dados dos Utilizadores
    $gestor->EXE_NON_QUERY('DELETE FROM utilizadores');
    $gestor->EXE_NON_QUERY('ALTER TABLE utilizadores AUTO_INCREMENT=1');+

    $data = new DateTime();
    
    //==============================================================
    // Utilizador 1 - Admin
    // Definição de Parametros
    $parametros = [
        ':utilizador'       => 'Admin',
        ':palavra_passe'    => md5('admin'),
        ':nome'             => 'Administrador',
        ':email'            => 'nncoelho.dev@gmail.com',
        ':permissoes'       => str_repeat('1', 100),
        ':criado_em'        => $data->format('Y-m-d H:i:s'),
        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
    ];

    // Inserir o Utilizador
    $gestor->EXE_NON_QUERY(
        'INSERT INTO utilizadores(utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
         $parametros);

    //==============================================================
    // Utilizador 2 - Nuno
    // Definição de Parametros
    $parametros = [
        ':utilizador'       => 'Nuno',
        ':palavra_passe'    => md5('abc123'),
        ':nome'             => 'Nuno Coelho',
        ':email'            => 'nncoelho.dev@gmail.com',
        ':permissoes'       => str_repeat('1', 100),
        ':criado_em'        => $data->format('Y-m-d H:i:s'),
        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
    ];

    // Inserir o Utilizador
    $gestor->EXE_NON_QUERY(
        'INSERT INTO utilizadores(utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
         $parametros);

    //==============================================================
    // Utilizador 3 - Vera
    // Definição de Parametros
    $parametros = [
        ':utilizador'       => 'Vera',
        ':palavra_passe'    => md5('verinha'),
        ':nome'             => 'Vera Matos',
        ':email'            => 'veramatos517@gmail.com',
        ':permissoes'       => '0'.str_repeat('1', 99),
        ':criado_em'        => $data->format('Y-m-d H:i:s'),
        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
    ];

    // Inserir o Utilizador
    $gestor->EXE_NON_QUERY(
        'INSERT INTO utilizadores(utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
         $parametros);

    //==============================================================
    // Utilizador 4 - Jorge
    // Definição de Parametros
    $parametros = [
        ':utilizador'       => 'Jorge',
        ':palavra_passe'    => md5('mata'),
        ':nome'             => 'Jorge Moita',
        ':email'            => 'matamoita@gmail.com',
        ':permissoes'       => '0'.str_repeat('1', 99),
        ':criado_em'        => $data->format('Y-m-d H:i:s'),
        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
    ];

    // Inserir o Utilizador
    $gestor->EXE_NON_QUERY(
        'INSERT INTO utilizadores(utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
         $parametros);
?>
<div class="alert alert-success text-center">Utilizadores inseridos com Sucesso.</div>