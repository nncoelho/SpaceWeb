<?php
//=========================================
// SETUP - INSERIR UTILIZADORES
//=========================================

// VERIFICA A SESSÃO
if (!isset($_SESSION['a'])) {
    exit();
}

// ACESSO A BASE DE DADOS
$gestor = new Gestor();

// LIMPA OS DADOS DOS UTILIZADORES E ZERA O AUTO_INCREMENT
$gestor->EXE_NON_QUERY('DELETE FROM utilizadores');
$gestor->EXE_NON_QUERY('ALTER TABLE utilizadores AUTO_INCREMENT = 1');
$data = new DateTime();

//==============================================================
// UTILIZADOR 1 - ADMIN PRIMÁRIO
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
    $parametros
);

//==============================================================
// UTILIZADOR 2 - NUNO - ADMIN SECUNDÁRIO
// DEFINIÇÃO DE PARAMETROS
$parametros = [
    ':utilizador'       => 'Nuno',
    ':palavra_passe'    => md5('nuno'),
    ':nome'             => 'Nuno Coelho',
    ':email'            => 'nuno@mail.com',
    ':permissoes'       => str_repeat('1', 100),
    ':criado_em'        => $data->format('Y-m-d H:i:s'),
    ':atualizado_em'    => $data->format('Y-m-d H:i:s')
];

// INSERIR O UTILIZADOR
$gestor->EXE_NON_QUERY(
    'INSERT INTO utilizadores(utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
    $parametros
);

//==============================================================
// UTILIZADOR 3 - RAUL
// DEFINIÇÃO DE PARAMETROS
$parametros = [
    ':utilizador'       => 'Raul',
    ':palavra_passe'    => md5('raul'),
    ':nome'             => 'Raul Seixas',
    ':email'            => 'raul@mail.com',
    ':permissoes'       => '0' . str_repeat('1', 99),
    ':criado_em'        => $data->format('Y-m-d H:i:s'),
    ':atualizado_em'    => $data->format('Y-m-d H:i:s')
];

// INSERIR O UTILIZADOR
$gestor->EXE_NON_QUERY(
    'INSERT INTO utilizadores(utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
    $parametros
);

//==============================================================
// UTILIZADOR 4 - ALBERTO
// DEFINIÇÃO DE PARAMETROS
$parametros = [
    ':utilizador'       => 'Alberto',
    ':palavra_passe'    => md5('alberto'),
    ':nome'             => 'Alberto Silva',
    ':email'            => 'alberto@mail.com',
    ':permissoes'       => '0' . str_repeat('1', 99),
    ':criado_em'        => $data->format('Y-m-d H:i:s'),
    ':atualizado_em'    => $data->format('Y-m-d H:i:s')
];

// INSERIR O UTILIZADOR
$gestor->EXE_NON_QUERY(
    'INSERT INTO utilizadores(utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
    $parametros
);
?>

<div class="alert alert-success text-center">Utilizadores inseridos com sucesso.</div>