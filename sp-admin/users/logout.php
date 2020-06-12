<?php 
    //=========================================
    // LOGOUT
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }

    $nome = $_SESSION['nome'];

    // EXECUTA O LOGOUT (DESTRUIÇÃO) DA SESSÃO
    funcoes::DestroiSessao();

    // LOG
    funcoes::CriarLOG('Utilizador '.$nome.' fez Logout.', $nome);
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4 card mt-5 p-4 text-center">            
            <p>Até à próxima, <strong><?php echo $nome ?></strong></p>
            <a href="?a=inicio" class="btn btn-primary">Início</a>
        </div>        
    </div>
</div>