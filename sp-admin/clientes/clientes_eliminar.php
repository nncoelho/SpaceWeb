<?php
//==================================================
// ELIMINAR CLIENTE VIA ID
//==================================================

// VERIFICA A SESSÃO
if (!isset($_SESSION['a'])) {
    exit();
}

$id_cliente = -1;
$erro = false;
$sucesso = false;
$mensagem = '';

if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];
}

// CARREGA OS DADOS DO CLIENTE
$gestor = new Gestor();
$parametros = ['id_cliente' => $id_cliente];
$dados = $gestor->EXE_QUERY('SELECT * FROM clientes WHERE id_cliente = :id_cliente', $parametros);

// VERIFICA SE O CLIENTE EXISTE
if (count($dados) == 0) {
    $erro = true;
    $mensagem = 'Não existe nenhum cliente a eliminar com o id indicado.';
}

// ELIMINAÇÃO DO CLIENTE
if (!$erro) {
    if (isset($_GET['eliminar'])) {
        $eliminar = $_GET['eliminar'];
        if ($eliminar) {
            $gestor->EXE_NON_QUERY('DELETE FROM clientes WHERE id_cliente = :id_cliente', $parametros);
            $sucesso = true;
            $mensagem = 'Cliente eliminado com sucesso.';
        }
    }
}
?>

<!-- QUADRO A QUESTIONAR A ELIMINAÇÃO -->
<div class="container">
    <div class="row">
        <div class="col-8 offset-2 text-center">
            <?php if ($erro) : ?>

                <?php echo '<div class="alert alert-danger mt-4 text-center">' . $mensagem . '</div>' ?>
                <a href="?a=clientes_lista" class="btn btn-primary mt-2 btn-size-150">Voltar</a>

            <?php else : ?>

                <?php if ($sucesso) : ?>

                    <?php echo '<div class="alert alert-success mt-4 text-center">' . $mensagem . '</div>' ?>
                    <a href="?a=clientes_lista" class="btn btn-primary mt-2 btn-size-150">Voltar</a>

                <?php else : ?>

                    <div class="card mt-5 p-5">
                        <h5>Tem a certeza que pretende eliminar o cliente:</h5>
                        <p>
                            <b><?php echo $dados[0]['nome'] ?></b> cujo o id é o número: <b><?php echo $dados[0]['id_cliente'] ?></b> ?
                        </p>
                        <div class="mt-3">
                            <a href="?a=clientes_lista" class="btn btn-secondary btn-size-100">Não</a>
                            <a href="?a=clientes_eliminar&id=<?php echo $id_cliente ?>&eliminar=true" class="btn btn-primary btn-size-100">Sim</a>
                        </div>
                    </div>

                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>
</div>