<?php 
    //=========================================
    // LOGOUT DOS CLIENTES
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }

    // GUARDA O NOME DO CLIENTE PARA SER APRESENTADO NO LOGOUT
    $nome = $_SESSION['nome_cliente'];

    // EXECUTA A DESTRUIÇÃO DA SESSÃO DO CLIENTE
    funcoes::DestroiSessaoCliente();
?>

<div class="container">
    <div class="row">
        <div class="col-sm-4 offset-sm-4 text-center p-5 card mt-5 mb-5">
            <p>Obrigado e até à próxima, <b><?php echo $nome ?></b>.</p>
            <div>
                <a href="?a=inicio" class="btn btn-primary btn-size-150">Ok</a>
            </div>
        </div>
    </div>
</div>