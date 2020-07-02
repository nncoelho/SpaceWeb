<?php 
    //=========================================
    // LOGOUT DOS UTILIZADORES
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
            <div class="text-center">
                <a href="?a=inicio" class="btn btn-primary btn-size-200">Início</a>
            </div>
        </div>        
    </div>
</div>