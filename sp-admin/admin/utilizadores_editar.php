<?php
    //========================================================
    // Gestão de Utilizadores - Editar Utilizador
    //========================================================

    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    }
    
    // Verificar Permissão
    $erro_permissao = false;
    if(!funcoes::Permissao(0)){
        $erro_permissao = true;
    }

    // Verifica se o id_utilizador está definido
    $id_utilizador = -1;
    if(isset($_GET['id'])){
        $id_utilizador = $_GET['id'];
    } else {
        $erro_permissao = true;
    }

    // Verifica se pode avançar (id_utilizador != 1 e != do da Sessão)
    if($id_utilizador == 1 || $id_utilizador == $_SESSION['id_utilizador']){
        $erro_permissao = true;
    }

    // ==============================================================
    $gestor = new cl_gestorBD();
    $dados_utilizador = null;  
   
    $erro = false;
    $sucesso = false;
    $mensagem = '';  
    
    if(!$erro_permissao){
        // Vai buscar os Dados do Utilizador
        $parametros = [':id_utilizador' => $id_utilizador];
        $dados_utilizador = $gestor->EXE_QUERY('SELECT * FROM utilizadores 
                                                WHERE id_utilizador = :id_utilizador', $parametros);
        // Verifica se existem Dados do Utilizador
        if(count($dados_utilizador)==0){
            $erro = true;
            $mensagem = 'Não foram encontrados dados do utilizador.';
        }
    }  
    
    //==============================================================
    // POST
    //==============================================================
    if($_SERVER['REQUEST_METHOD']== 'POST'){
        
        // Vai buscar os Dados das text's
        $nome = $_POST['text_nome'];
        $email = $_POST['text_email'];

        // Verificações - Verifica se existe outro Utilizador com o mesmo Email
        $parametros = [
            ':id_utilizador' => $id_utilizador,
            ':email'         => $email
        ];        

        $temp = $gestor->EXE_QUERY('SELECT * FROM utilizadores
                                    WHERE id_utilizador <> :id_utilizador
                                    AND email = :email', $parametros);
        if(count($temp) != 0){
            $erro = true;
            $mensagem = 'Já existe outro utilizador com o mesmo email.';
        }

        //========================================
        // Atualiza os Dados na Base de Dados
        if(!$erro){
            $parametros = [
                ':id_utilizador' => $id_utilizador,
                ':nome'          => $nome,
                ':email'         => $email,
                ':atualizado_em' => DATAS::DataHoraAtualBD()
            ];  
            
            $gestor->EXE_NON_QUERY(
                'UPDATE utilizadores SET
                nome  = :nome,
                email = :email,
                atualizado_em = :atualizado_em
                WHERE id_utilizador = :id_utilizador',$parametros);
            
            // Sucesso
            $sucesso = true;
            $mensagem = 'Dados atualizados com sucesso.';

            $parametros = [':id_utilizador' => $id_utilizador];
            $dados_utilizador = $gestor->EXE_QUERY('SELECT * FROM utilizadores WHERE id_utilizador = :id_utilizador', $parametros);
        }
    }
?>

<!-- Erro de Permissão -->
<?php if($erro_permissao) : ?>
    <?php include('inc/sem_permissao.php') ?>
<?php else : ?>

    <!-- Erro de falta de Dados -->
    <?php if($erro) : ?>

        <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col-md-6 offset-md-3 text-center">
                    <p class="alert alert-danger"><?php echo $mensagem ?></p>
                    <a href="?a=utilizadores_gerir" class="btn btn-primary btn-size-100">Voltar</a>
                </div>
            </div>
        </div>

    <?php else : ?>
    
        <!-- Apresenta uma mensagem de Sucesso -->
        <?php if($sucesso): ?>
            <div class="alert alert-success text-center">
                <?php echo $mensagem ?>
            </div>
        <?php endif; ?>

        <!-- Formulário com os Dados para Alteração -->
        <div class="container">
            <div class="row card mt-3 mb-3">
                <h4 class="text-center mt-4">Editar Dados do Utilizador</h4>

                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="mt-3 mb-3">
                            <form action="?a=editar_utilizador&id=<?php echo $id_utilizador ?>" method="post">
                                <div class="form-group">
                                    <label>Utilizador:</label>
                                    <p><strong><?php echo $dados_utilizador[0]['utilizador'] ?></strong></p>

                                    <!-- Nome Completo -->
                                    <div class="form-group">
                                        <label>Nome:</label>
                                        <input type="text"
                                            name="text_nome"
                                            class="form-control"
                                            pattern=".{3,50}"
                                            title="Entre 3 e 50 caracteres."
                                            placeholder="<?php echo $dados_utilizador[0]['nome'] ?>"
                                            required>
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input type="email"
                                            name="text_email"
                                            class="form-control"
                                            pattern=".{3,50}"
                                            title="Entre 3 e 50 caracteres."
                                            placeholder="<?php echo $dados_utilizador[0]['email'] ?>"
                                            required>
                                    </div>

                                    <div class="text-center">
                                        <a href="?a=utilizadores_gerir" class="btn btn-primary btn-size-150">Cancelar</a>
                                        <button class="btn btn-primary btn-size-150">Atualizar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

<?php endif; ?>