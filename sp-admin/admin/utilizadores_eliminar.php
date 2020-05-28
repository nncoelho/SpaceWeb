<?php
    //==============================================================
    // GESTÃO DE UTILIZADORES - ELIMINAR UTILIZADOR
    //==============================================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }
    
    // VERIFICA PERMISSÃO
    $erro_permissao = false;
    if(!funcoes::Permissao(0)){
        $erro_permissao = true;
    }

    // VERIFICA SE ID_UTILIZADOR ESTÁ DEFINIDO
    $id_utilizador = -1;
    if(isset($_GET['id'])){
        $id_utilizador = $_GET['id'];
    } else {
        $erro_permissao = true;
    }

    // VERIFICA SE PODE AVANÇAR (ID_UTILIZADOR != 1 E != DO DA SESSÃO)
    if($id_utilizador == 1 || $id_utilizador == $_SESSION['id_utilizador']){
        $erro_permissao = true;
    }

    //==============================================================
    $dados_utilizador = null;
    $gestor = new Gestor();
    if(!$erro_permissao){
        // VAI BUSCAR OS DADOS DO UTILIZADOR
        $parametros = [':id_utilizador' => $id_utilizador];
        $dados_utilizador = $gestor->EXE_QUERY('SELECT * FROM utilizadores
                                                WHERE id_utilizador = :id_utilizador', $parametros);
    }

    //==============================================================
    // VERIFICA SE FOI DADA RESPOSTA AFIRMATIVA PARA ELIMINAÇÃO
    $sucesso = false;
    if(isset($_GET['r'])){
        if($_GET['r']==1){
            
            // REMOVER O UTILIZADOR DA BASE DE DADOS
            $parametros = [':id_utilizador' => $id_utilizador];            
            $gestor->EXE_NON_QUERY('DELETE FROM utilizadores WHERE id_utilizador = :id_utilizador', $parametros);

            // INFORMA O SISTEMA QUE A REMOÇÃO DO UTILIZADOR ACONTECEU COM SUCESSO.
            $sucesso = true;
        }
    }
?>

<!-- SEM PERMISSÃO -->
<?php if($erro_permissao) : ?>
    <?php include('inc/sem_permissao.php') ?>
<?php else : ?>

    <!-- REMOÇÃO COM SUCESSO -->
    <?php if($sucesso) :?>
        
        <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col-md-6 offset-md-3 text-center">
                    <p class="alert alert-success">Utilizador Removido com Sucesso.</p>
                    <a href="?a=utilizadores_gerir" class="btn btn-primary btn-size-100">Voltar</a>
                </div>
            </div>
        </div>

    <?php else : ?>

        <!-- APRESENTAÇÃO DOS DADOS DO UTILIZADOR A REMOVER -->
        <div class="container">
            <div class="mt-3 mb-3 p-3">
                <h4 class="text-center">Remover Utilizador</h4>                    

                <!-- DADOS DO UTILIZADOR -->
                <div class="row">
                    <div class="col-md-8 offset-md-2 card mt-3 mb-3 p-3">

                        <p class="text-center">Tem a certeza que pretende eliminar o Utilizador:<br>
                            <strong><?php echo $dados_utilizador[0]['nome'] ?></strong>, cujo email é: 
                            <strong><?php echo $dados_utilizador[0]['email'] ?></strong> ?
                        </p>

                        <!-- BOTÕES NÃO E SIM -->
                        <div class="text-center mt-3 mb-3">
                            <a href="?a=utilizadores_gerir" class="btn btn-primary btn-size-100">Não</a>
                            <a href="?a=eliminar_utilizador&id=<?php echo $id_utilizador ?>&r=1" class="btn btn-primary btn-size-100">Sim</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

<?php endif; ?>