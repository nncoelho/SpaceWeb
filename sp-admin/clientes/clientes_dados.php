<?php
//==================================================
// VISUALIZAÇÃO DOS DADOS DO CLIENTE VIA ID
//==================================================

// VERIFICA A SESSÃO
if (!isset($_SESSION['a'])) {
    exit();
}

$id = -1;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$gestor = new Gestor();
$cliente = null;

if ($id != -1) {

    $parametros = [':id_cliente' => $id];
    $dados = $gestor->EXE_QUERY(
        'SELECT * FROM clientes 
                                     WHERE id_cliente = :id_cliente',
        $parametros
    );

    $cliente = $dados[0];
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-2">

            <?php if ($id != -1) : ?>

                <!-- APRESENTAR OS DADOS DO CLIENTE -->
                <div class="card mt-5 mb-5 p-4">
                    <h4 class="text-center mb-5"><i class="fa fa-id-card"></i> Dados do Cliente</h4>
                    <p class="ml-5"><i class="fa fa-user-circle-o"></i> <b><?php echo $cliente['nome'] ?></b></p>
                </div>
                <div class="text-center">
                    <a href="?a=clientes_lista" class="btn btn-primary btn-size-150 text-center">Voltar</a>
                </div>

            <?php else : ?>
                <!-- ERRO -->
                <div class="alert alert-danger text-center mt-4">
                    Não existe nenhum cliente a apresentar com o ID indicado.
                </div>
                <div class="text-center">
                    <a href="?a=clientes_lista" class="btn btn-primary btn-size-150 mt-2 text-center">Voltar</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>