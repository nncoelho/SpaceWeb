<?php 
    //========================================
    // Logout
    //========================================

    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    // Guardar o Nome do Cliente para ser apresentado no Logout
    $nome = $_SESSION['nome_cliente'];

    // Executa a Destruição da Sessão do Cliente
    funcoes::DestroiSessaoCliente();
?>

<div class="container">
    <div class="row">
        <div class="col-sm-4 offset-sm-4 text-center p-3 card mt-5 mb-5">
            <p>Até à próxima, <b><?php echo $nome ?></b></p>
            <div>
                <a href="?a=home" class="btn btn-primary btn-size-150">Ok</a>
            </div>
        </div>
    </div>
</div>