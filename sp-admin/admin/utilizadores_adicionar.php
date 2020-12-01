<?php
//==============================================================
// GESTÃO DE UTILIZADORES - ADICIONAR NOVO UTILIZADOR
//==============================================================

// VERIFICA A SESSÃO
if (!isset($_SESSION['a'])) {
    exit();
}

// VERIFICA PERMISSÃO
$erro_permissao = false;
if (!funcoes::Permissao(0)) {
    $erro_permissao = true;
}

$gestor = new Gestor();
$erro = false;
$sucesso = false;
$mensagem = '';

//==============================================================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // VAI BUSCAR OS VALORES DO FORMULÁRIO
    $utilizador =       $_POST['text_utilizador'];
    $password  =        $_POST['text_password'];
    $nome_completo =    $_POST['text_nome'];
    $email =            $_POST['text_email'];

    // PERMISSOES
    $total_permissoes = (count(include('../inc/permissoes.php')));
    $permissoes = [];
    if (isset($_POST['check_permissao'])) {
        $permissoes = $_POST['check_permissao'];
    }

    $permissoes_finais = '';
    for ($i = 0; $i < 100; $i++) {

        if ($i < $total_permissoes) {
            if (in_array($i, $permissoes)) {
                $permissoes_finais .= '1';
            } else {
                $permissoes_finais .= '0';
            }
        } else {
            $permissoes_finais .= '1';
        }
    }

    //==========================================================
    // VERIFICA OS DADOS NA BASE DE DADOS
    //==========================================================

    // VERIFICA SE EXISTE ALGUM UTILIZADOR COM O NOME IGUAL
    $parametros = [
        ':utilizador' => $utilizador
    ];

    $dtemp = $gestor->EXE_QUERY(
        'SELECT utilizador 
                                     FROM utilizadores
                                     WHERE utilizador = :utilizador',
        $parametros
    );

    if (count($dtemp) != 0) {
        $erro = true;
        $mensagem = 'Já existe um utilizador com o mesmo nome.';
    }

    // VERIFICA SE EXISTE OUTRO UTILIZADOR COM O MESMO E-MAIL
    if (!$erro) {
        $parametros = [
            ':email' => $email
        ];

        $dtemp = $gestor->EXE_QUERY(
            'SELECT email 
                                         FROM utilizadores
                                         WHERE email = :email',
            $parametros
        );

        if (count($dtemp) != 0) {
            $erro = true;
            $mensagem = 'Já existe outro utilizador com o mesmo E-mail.';
        }
    }

    // GUARDAR NA BASE DE DADOS
    if (!$erro) {
        $parametros = [
            ':utilizador'       => $utilizador,
            ':palavra_passe'    => md5($password),
            ':nome'             => $nome_completo,
            ':email'            => $email,
            ':permissoes'       => $permissoes_finais,
            ':criado_em'        => Datas::DataHoraAtualBD(),
            ':atualizado_em'    => Datas::DataHoraAtualBD()
        ];

        $gestor->EXE_NON_QUERY(
            '
                INSERT INTO utilizadores
                    (utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
                VALUES
                    (:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
            $parametros
        );

        // ENVIAR O E-MAIL PARA O NOVO UTILIZADOR
        $mensagem = [
            $email,
            'SpaceWeb - Criação de Nova Conta de Utilizador',
            "<h4>Foi criada a sua nova conta de utilizador com os seguintes dados:</h4><p><b>Utilizador:</b> $utilizador </p><p><b>Password:</b> $password </p>"
        ];

        $mail = new emails();

        $mail->EnviarEmail($mensagem);

        // APRESENTAR UM ALERTA DE SUCESSO
        echo '<div class="alert alert-success text-center">Novo utilizador adicionado com sucesso.</div>';
    }
}
?>

<!-- ERRO DE PERMISSÃO -->
<?php if ($erro_permissao) : ?>
    <?php include('../inc/sem_permissao.php') ?>
<?php else : ?>

    <!-- APRESENTA O ERRO NO CASO DE EXISTIR -->
    <?php
    if ($erro) {
        echo '<div class="alert alert-danger text-center">' . $mensagem . '</div>';
    }
    ?>

    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-sm-8 card my-5 p-5">

                <h4 class="text-center"><i class="fa fa-address-book" aria-hidden="true"></i> Adicionar Novo Utilizador</h4>
                <hr>
                <!-- FORMULÁRIO PARA ADICIONAR NOVO UTILIZADOR -->
                <form action="?a=utilizadores_adicionar" method="POST">

                    <!-- UTILIZADOR -->
                    <div class="form-group">
                        <label>Utilizador:</label>
                        <input type="text" name="text_utilizador" class="form-control" pattern=".{3,50}" title="Entre 3 e 50 caracteres." required>
                    </div>

                    <!-- PASSWORD -->
                    <div class="form-group">
                        <label>Password:</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" name="text_password" id="text_password" class="form-control" pattern=".{3,30}" title="Entre 3 e 30 caracteres." required>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-warning" onclick="gerarPassword(10)">
                                    <i class="fa fa-bolt" aria-hidden="true"></i>&nbsp;&nbsp;Gerar Password
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- NOME COMPLETO -->
                    <div class="form-group">
                        <label>Nome:</label>
                        <input type="text" name="text_nome" class="form-control" pattern=".{3,50}" title="Entre 3 e 50 caracteres." required>
                    </div>

                    <!-- E-MAIL -->
                    <div class="form-group">
                        <label>E-mail:</label>
                        <input type="email" name="text_email" class="form-control" pattern=".{3,50}" title="Entre 3 e 50 caracteres." required>
                    </div>

                    <div class="text-center my-4">
                        <a href="?a=utilizadores_gerir" class="btn btn-secondary btn-size-150">Cancelar</a>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-primary btn-size-150">Criar Utilizador</button>
                    </div>

                    <hr class="my-4">

                    <div class="text-center my-4">
                        <button type="button" class="btn btn-dark" data-toggle="collapse" data-target="#caixa_permissoes"><i class="fa fa-wrench fa-lg" aria-hidden="true"></i>&nbsp;&nbsp; Definir Permissões
                        </button>
                    </div>

                    <!-- CAIXA PERMISSÕES -->
                    <div class="collapse" id="caixa_permissoes">
                        <div class="card p-3 caixa-permissoes">
                            <?php
                            $permissoes = include('../inc/permissoes.php');
                            $id = 0;
                            foreach ($permissoes as $permissoes_finais) {
                            ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="check_permissao[]" id="check_permissao" value="<?php echo $id ?> ">
                                        <span class="permissao-titulo"><?php echo $permissoes_finais['permissao'] ?></span>
                                    </label>
                                    <p class="permissao-sumario"><?php echo $permissoes_finais['sumario'] ?></p>
                                </div>

                            <?php $id++;
                            } ?>

                            <!-- TODAS | NENHUMA -->
                            <div>
                                <a href="#" onclick="checks(true); return false">Todas</a> <i class="fa fa-check-square" aria-hidden="true"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="#" onclick="checks(false); return false">Nenhuma</a> <i class="fa fa-square-o" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

<?php endif; ?>