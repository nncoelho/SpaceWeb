<?php
//=========================================
// SIGNUP DOS CLIENTES
//=========================================

// VERIFICA A SESSÃO
if (!isset($_SESSION['a'])) {
    exit();
}

$erro = false;
$mensagem = '';
$gestor = new Gestor();

// DADOS DO CLIENTE
$nome = '';
$email = '';
$utilizador = '';
$codigo_validacao = '';

//========================================
// VERIFICA SE FOI FEITO POST
//========================================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // RECOLHA DOS DADOS
    $nome = $_POST['text_nome_completo'];
    $email = $_POST['text_email'];
    $utilizador = $_POST['text_utilizador'];
    $senha1 = $_POST['text_senha_1'];
    $senha2 = $_POST['text_senha_2'];

    // VERIFICA SE AS SENHAS CORRESPONDEM
    if ($senha1 != $senha2) {
        $erro = true;
        $mensagem = 'As senhas não coincidem. Tente novamente e faça-as coincidir.';
    }

    // VERIFICA SE JÁ EXISTE UM CLIENTE COM OS MESMOS DADOS
    if (!$erro) {
        $parametros = [
            ':nome'             => $nome,
            ':email'            => $email,
            ':utilizador'       => $utilizador
        ];

        $dados = $gestor->EXE_QUERY('
                SELECT * FROM clientes WHERE
                nome = :nome OR
                email = :email OR
                utilizador = :utilizador', $parametros);

        if (count($dados) != 0) {
            $erro = true;
            $mensagem = 'Já existe um cliente com o mesmo nome, email ou utilizador definido.';
        }
    }

    // CRIA CONDIÇÕES PARA CRIAR A CONTA DE CLIENTE (EM VALIDAÇÃO)
    if (!$erro) {
        $codigo_validacao = funcoes::CriarCodigoAlfanumerico(30);
        $data = new DateTime();

        $parametros = [
            ':nome'             => $nome,
            ':email'            => $email,
            ':utilizador'       => $utilizador,
            ':palavra_passe'    => md5($senha1),
            ':codigo_validacao' => funcoes::CriarCodigoAlfanumericoSemSinais(30),
            ':validada'         => 0,
            ':criado_em'        => $data->format('Y-m-d H:i:s'),
            ':atualizado_em'    => $data->format('Y-m-d H:i:s')
        ];

        // REGISTA O CLIENTE NA BASE DE DADOS
        $gestor->EXE_NON_QUERY('
                INSERT INTO
                clientes(nome, email, utilizador, palavra_passe, codigo_validacao, validada, criado_em, atualizado_em)
                VALUES
                (:nome, :email, :utilizador, :palavra_passe, :codigo_validacao, :validada, :criado_em, :atualizado_em)', $parametros);

        // ENVIO DO EMAIL PARA O CLIENTE VALIDAR/ATIVAR A SUA CONTA
        $email_a_enviar = new emails();

        // CRIA O LINK DE ATIVAÇÃO
        $config = include('inc/config.php');
        $link = $config['BASE_URL'] . '?a=validar&v=' . $parametros[':codigo_validacao'];

        // PREPARAÇÃO DOS DADOS DO EMAIL
        $temp = [
            $email,

            '<h3>SpaceWeb - Ativação da Conta de Cliente</h3>',
            '<p>Clique no link seguinte para validar e ativar a sua conta de cliente:</p>' .

                '<a href="' . $link . '">' . $link . '</a>'
        ];

        // ENVIO DO EMAIL
        $mensagem_enviada = $email_a_enviar->EnviarEmailCliente($temp);
    }
}
?>

<!-- MENSAGEM DE ERRO -->
<?php if ($erro) {
    echo '<div class="alert alert-danger text-center">' . $mensagem . '</div>';
}
?>

<div class="container signup mt-5 mb-5">
    <div class="row">
        <div class="col-sm-6 offset-3">
            <div class="text-center mb-4">
                <h3><i class="fa fa-handshake-o fa-lg mr-2"></i>Nova Conta de Cliente</h3>
            </div>

            <form action="" method="post">
                <!-- NOME COMPLETO DO CLIENTE -->
                <div class="form-group">
                    <input type="text" class="form-control" name="text_nome_completo" placeholder="Nome completo" value="<?php echo $nome ?>" required>
                </div>
                <!-- EMAIL -->
                <div class="form-group">
                    <input type="email" class="form-control" name="text_email" placeholder="E-mail" value="<?php echo $email ?>" required>
                </div>
                <!-- UTILIZADOR -->
                <div class="form-group">
                    <input type="text" class="form-control" name="text_utilizador" placeholder="Utilizador" value="<?php echo $utilizador ?>" required>
                </div>
                <!-- SENHA 1 -->
                <div class="form-group">
                    <input type="password" class="form-control" name="text_senha_1" placeholder="Senha" required>
                </div>
                <!-- SENHA 2 (VERIFICAÇÃO) -->
                <div class="form-group">
                    <input type="password" class="form-control" name="text_senha_2" placeholder="Repetir a senha" required>
                </div>
                <!-- ACEITAÇÃO DOS TERMOS E CONDIÇÕES DE UTILIZAÇÃO -->
                <div class="text-center form-group">
                    <input type="checkbox" name="check_termos" id="check_termos" class="mr-2" required>
                    <label for="check_termos">Li e Aceito os <a href="#">Termos e Condições de Utilização</a>.</label>
                </div>
                <!-- SUBMETER -->
                <div class="text-center">
                    <a href="?a=inicio" class="btn btn-secondary mb-5 btn-size-150">Voltar</a>&nbsp;&nbsp;
                    <button class="btn btn-primary mb-5 btn-size-150">Criar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>