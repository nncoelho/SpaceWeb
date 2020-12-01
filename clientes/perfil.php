<?php
//=========================================
// PERFIL DOS CLIENTES
//=========================================

// VERIFICA A SESSÃO
if (!isset($_SESSION['a'])) {
    exit();
}

if (!funcoes::VerificarLoginCliente()) {
    exit();
}

$erro = false;
$sucesso = false;
$mensagem = '';

//=========================================
// MÉTODO POST
//=========================================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $p = $_GET['p'];
    $id_cliente = $_SESSION['id_cliente'];
    $gestor = new Gestor();
    $data = new DateTime();

    switch ($p) {

        case 1:
            // ALTERA O NOME DO CLIENTE
            $parametros = [
                ':id_cliente' => $id_cliente,
                ':nome'       => $_POST['text_nome']
            ];

            $dados = $gestor->EXE_QUERY(
                'SELECT id_cliente, nome FROM clientes
                                             WHERE id_cliente <> :id_cliente
                                             AND nome = :nome',
                $parametros
            );

            if (count($dados) != 0) {
                // FOI ENCONTRADO OUTRO CLIENTE COM O MESMO NOME
                $erro = true;
                $mensagem = 'Já existe outro cliente com o mesmo nome.';
            } else {
                $parametros = [
                    ':id_cliente'       => $id_cliente,
                    ':nome'             => $_POST['text_nome'],
                    ':atualizado_em'    => $data->format('Y-m-d H:i:s')
                ];

                $gestor->EXE_NON_QUERY(
                    'UPDATE clientes SET
                                            nome = :nome,
                                            atualizado_em = :atualizado_em
                                            WHERE id_cliente = :id_cliente',
                    $parametros
                );

                $sucesso = true;
                $mensagem = 'Nome completo do cliente alterado com sucesso.';
            }
            break;

        case 2:
            // ALTERA O E-MAIL DO CLIENTE
            $text_email_1 = $_POST['text_email'];
            $text_email_2 = $_POST['text_email_repetir'];

            // VERIFICA SE OS E-MAILS INTRODUZIDOS COINCIDEM
            if ($text_email_1 != $text_email_2) {
                $erro = true;
                $mensagem = 'Os e-mails introduzidos não coincidem. Tente novamente e faça-os coincidir.';
            }

            // VERIFICA SE JÁ EXISTE OUTRO CLIENTE COM O MESMO E-MAIL
            if (!$erro) {
                $parametros = [
                    ':id_cliente'   => $id_cliente,
                    ':email'        => $text_email_1
                ];

                $dados = $gestor->EXE_QUERY(
                    'SELECT id_cliente, email FROM clientes
                                                 WHERE id_cliente <> :id_cliente
                                                 AND email = :email',
                    $parametros
                );

                if (count($dados) != 0) {
                    $erro = true;
                    $mensagem = 'Já existe outro cliente com o mesmo e-mail.';
                }
            }

            // ATUALIZAÇÃO DO E-MAIL DO CLIENTE NA BASE DE DADOS
            if (!$erro) {
                $parametros = [
                    ':id_cliente'       => $id_cliente,
                    ':email'            => $text_email_1,
                    ':atualizado_em'    => $data->format('Y-m-d H:i:s')
                ];

                $gestor->EXE_NON_QUERY(
                    'UPDATE clientes SET
                                            email = :email,
                                            atualizado_em = :atualizado_em
                                            WHERE id_cliente = :id_cliente',
                    $parametros
                );

                $sucesso = true;
                $mensagem = 'E-mail do cliente alterado com sucesso.';
            }
            break;

        case 3:
            // ALTERA A PASSWORD DO CLIENTE
            $text_senha_atual = $_POST['text_senha_atual'];
            $text_senha_nova = $_POST['text_senha_nova'];
            $text_senha_nova_1 = $_POST['text_senha_nova_1'];

            // VERIFICA SE A PASSWORD ATUAL É A MESMA DA BASE DE DADOS
            $parametros = [
                ':id_cliente'       => $id_cliente,
                ':palavra_passe'    => md5($text_senha_atual)
            ];

            $dados = $gestor->EXE_QUERY(
                'SELECT id_cliente, palavra_passe FROM clientes
                                             WHERE id_cliente = :id_cliente 
                                             AND palavra_passe = :palavra_passe',
                $parametros
            );

            if (count($dados) == 0) {
                // EXISTE UM ERRO - A PASSWORD NÃO É IGUAL À QUE SE ENCONTRA NA BD
                $erro = true;
                $mensagem = 'A password que introduziu não corresponde à password atual.';
            }

            // VERIFICA SE A NOVA PASSWORD E A PASSWORD REPETIDA SÃO IGUAIS
            if (!$erro) {
                if ($text_senha_nova != $text_senha_nova_1) {
                    // AS PASSWORDS NOVAS NÃO COINCIDEM
                    $erro = true;
                    $mensagem = 'As passwords novas não coincidem. Tente novamente e faça-as coincidir.';
                }
            }

            // ATUALIZAR NOVA PASSWORD NA BASE DE DADOS
            if (!$erro) {
                $parametros = [
                    ':id_cliente'       => $id_cliente,
                    ':palavra_passe'    => md5($text_senha_nova),
                    ':atualizado_em'    => $data->format('Y-m-d H:i:s')
                ];

                $gestor->EXE_NON_QUERY(
                    'UPDATE clientes SET
                                            palavra_passe = :palavra_passe,
                                            atualizado_em = :atualizado_em
                                            WHERE id_cliente = :id_cliente',
                    $parametros
                );

                $sucesso = true;
                $mensagem = 'Password do cliente alterada com sucesso.';
            }
            break;
    }
}

// VAI BUSCAR OS DADOS DO CLIENTE
$parametros = [
    ':id_cliente' => $_SESSION['id_cliente']
];
$gestor = new Gestor();
$dados_cliente = $gestor->EXE_QUERY(
    'SELECT * FROM clientes 
                                         WHERE id_cliente = :id_cliente',
    $parametros
);
$dados = $dados_cliente[0]; // PASSA OS DADOS TODOS PARA UM ARRAY UNIDIMENSIONAL
?>

<!-- MENSAGEM DE ERRO -->
<?php if ($erro) : ?>
    <div class="alert alert-danger mb-0 text-center">
        <?php echo $mensagem ?>
    </div>
<?php endif; ?>

<!-- MENSAGEM DE SUCESSO -->
<?php if ($sucesso) : ?>
    <div class="alert alert-success mb-0 text-center">
        <?php echo $mensagem ?>
    </div>
<?php endif; ?>

<!-- EDITAR PERFIL DO CLIENTE -->
<div class="container-fluid perfil">

    <div class="container p-4">
        <h3 class="text-center mb-3">Editar perfil do cliente</h3>

        <div class="col-md-8 offset-2 col-xs-12">

            <div id="accordion">

                <!-- ALTERAR NOME DE UTILIZADOR -->
                <div class="card">
                    <div class="card-header" id="caixa_utilizador">
                        <h6 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#t_1" aria-expanded="false" aria-controls="collapseOne">Alterar nome completo
                            </button>
                        </h6>
                    </div>

                    <div id="t_1" class="collapse show" aria-labelledby="caixa_utilizador" data-parent="#accordion">
                        <div class="card-body">

                            <!-- FORMULÁRIO PARA ALTERAR O NOME DO UTILIZADOR -->
                            <div class="ml-1">
                                Nome completo atual: <b><?php echo $dados['nome'] ?></b>
                            </div>

                            <form action="?a=perfil&p=1" method="post" class="mt-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="text_nome" placeholder="Insira aqui o seu nome completo" required>
                                </div>
                                <div class="text-right">
                                    <input type="submit" value="Alterar" class="btn btn-primary btn-size-150">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ALTERAR EMAIL -->
                <div class="card">
                    <div class="card-header" id="caixa_email">
                        <h6 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#t_2" aria-expanded="false" aria-controls="collapseTwo">Alterar e-mail
                            </button>
                        </h6>
                    </div>

                    <div id="t_2" class="collapse" aria-labelledby="caixa_email" data-parent="#accordion">
                        <div class="card-body">

                            <!-- FORMULÁRIO PARA ALTERAR O EMAIL -->
                            <div class="ml-1">
                                E-mail atual: <b><?php echo $dados['email'] ?></b>
                            </div>

                            <form action="?a=perfil&p=2" method="post" class="mt-3">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="text_email" placeholder="Insira aqui o seu novo endereço de e-mail" required>
                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control" name="text_email_repetir" placeholder="Confirme o seu novo endereço de e-mail" required>
                                </div>

                                <div class="text-right">
                                    <input type="submit" value="Alterar" class="btn btn-primary btn-size-150">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ALTERAR SENHA -->
                <div class="card">
                    <div class="card-header" id="caixa_senha">
                        <h6 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#t_3" aria-expanded="false" aria-controls="collapseThree">Alterar password
                            </button>
                        </h6>
                    </div>

                    <div id="t_3" class="collapse" aria-labelledby="caixa_senha" data-parent="#accordion">
                        <div class="card-body">

                            <!-- FORMULÁRIO PARA ALTERAR A SENHA -->
                            <form action="?a=perfil&p=3" method="post" class="mt-3">
                                <div class="form-group">
                                    <input type="password" class="form-control" name="text_senha_atual" placeholder="Insira aqui a sua password atual" required>
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" name="text_senha_nova" placeholder="Insira aqui a sua nova password" required>
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" name="text_senha_nova_1" placeholder="Confirme a sua nova password" required>
                                </div>

                                <div class="text-right">
                                    <input type="submit" value="Alterar" class="btn btn-primary btn-size-150">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>