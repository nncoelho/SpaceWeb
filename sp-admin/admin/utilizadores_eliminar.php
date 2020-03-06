<?php
    //==============================================================
    // Gestão de Utilizadores - Eliminar Utilizador
    //==============================================================

    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    }
    
    // Verificar Permissão
    $erro_permissao = false;
    if(!funcoes::Permissao(0)){
        $erro_permissao = true;
    }

    // Verifica se id_utilizador está definido
    $id_utilizador = -1;
    if(isset($_GET['id'])){
        $id_utilizador = $_GET['id'];
    } else {
        $erro_permissao = true;
    }

    // Verifica se pode avançar (id_utilizador != 1 e != do da sessão)
    if($id_utilizador == 1 || $id_utilizador == $_SESSION['id_utilizador']){
        $erro_permissao = true;
    }

    //==============================================================
    $dados_utilizador = null;
    $gestor = new cl_gestorBD();
    if(!$erro_permissao){
        // Vai buscar os Dados do Utilizador
        $parametros = [':id_utilizador' => $id_utilizador];
        $dados_utilizador = $gestor->EXE_QUERY('SELECT * FROM utilizadores
                                                WHERE id_utilizador = :id_utilizador', $parametros);
    }

    //==============================================================
    // Verifica se foi dada resposta afirmativa para eliminação
    $sucesso = false;
    if(isset($_GET['r'])){
        if($_GET['r']==1){
            
            // Remover o Utilizador da Base de Dados
            $parametros = [':id_utilizador' => $id_utilizador];            
            $gestor->EXE_NON_QUERY('DELETE FROM utilizadores WHERE id_utilizador = :id_utilizador', $parametros);

            // Informa o sistema que a remoção do Utilizador aconteceu com Sucesso.
            $sucesso = true;
        }
    }
?>

<!-- Sem Permissão -->
<?php if($erro_permissao) : ?>
    <?php include('inc/sem_permissao.php') ?>
<?php else : ?>

    <!-- Remoção com Sucesso -->
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

        <!-- Apresentação dos Dados do Utilizador a remover -->
        <div class="container">
            <div class="mt-3 mb-3 p-3">
                <h4 class="text-center">Remover Utilizador</h4>                    

                <!-- Dados do Utilizador -->
                <div class="row">
                    <div class="col-md-8 offset-md-2 card mt-3 mb-3 p-3">

                        <p class="text-center">Tem a certeza que pretende eliminar o Utilizador:<br>
                            <strong><?php echo $dados_utilizador[0]['nome'] ?></strong>, cujo email é: 
                            <strong><?php echo $dados_utilizador[0]['email'] ?></strong> ?
                        </p>

                        <!-- Botões Não e Sim -->
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