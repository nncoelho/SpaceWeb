<?php 
    //=========================================
    // PERFIL UTILIZADORES
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }

    $erro = false;
    $mensagem = '';

    // VERIFICA SE TEM PERMISSÃO PARA ACEDER AO SISTEMA
    if(!funcoes::Permissao(4)){
        $erro = true;
        $mensagem = 'Não tem permissão.';
    }

    // VAI BUSCAR TODAS AS INFORMAÇÕES DO UTILIZADOR
    $gestor = new Gestor();
    $parametros = [
        ':id_utilizador' => $_SESSION['id_utilizador']
    ];
    $dados = $gestor->EXE_QUERY(
        'SELECT * FROM utilizadores 
         WHERE id_utilizador = :id_utilizador',$parametros);
?>

<?php if($erro) :?>

    <div class="text-center">
        <h3><?php echo $mensagem ?></h3>
        <a href="?a=inicio" class="btn btn-primary btn-size-150">Voltar</a>
    </div>

<?php else :?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 card mt-5 p-5">
                <h4 class="text-center mb-5"><i class="fa fa-id-card-o"></i> Perfil do Utilizador</h4>
                <!-- DADOS DO UTILIZADOR -->
                <h5><i class="fa fa-user"></i> <?php echo $dados[0]['nome'] ?></h5>
                <p><i class="fa fa-envelope"></i> <?php echo $dados[0]['email'] ?></p>
            </div>          
        </div>
        <div class="text-center">
            <!-- VOLTAR -->
            <a href="?a=inicio" class="btn btn-primary btn-size-150 mt-4">Voltar</a>
        </div>
    </div>

<?php endif; ?>