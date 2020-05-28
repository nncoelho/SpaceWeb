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
    funcoes::CriarLOG('Utilizador '.$nome.' fez logout.', $nome);
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4 card m-3 p-3 text-center">            
            <p>Até à próxima, <?php echo $nome ?></p>
            <a href="?a=inicio" class="btn btn-primary">Início</a>
        </div>        
    </div>
</div>