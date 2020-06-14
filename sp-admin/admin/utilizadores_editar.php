<?php
    //========================================================
    // GESTÃO DE UTILIZADORES - EDITAR UTILIZADOR
    //========================================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }
    
    // VERIFICA PERMISSÃO
    $erro_permissao = false;
    if(!funcoes::Permissao(0)){
        $erro_permissao = true;
    }

    // VERIFICA SE O ID_UTILIZADOR ESTÁ DEFINIDO
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

    // =======================================================
    $gestor = new Gestor();
    $dados_utilizador = null;  
   
    $erro = false;
    $sucesso = false;
    $mensagem = '';  
    
    if(!$erro_permissao){
        // VAI BUSCAR OS DADOS DO UTILIZADOR
        $parametros = [':id_utilizador' => $id_utilizador];
        $dados_utilizador = $gestor->EXE_QUERY('SELECT * FROM utilizadores 
                                                WHERE id_utilizador = :id_utilizador', $parametros);
        // VERIFICA SE EXISTEM DADOS DO UTILIZADOR
        if(count($dados_utilizador)==0){
            $erro = true;
            $mensagem = 'Não foram encontrados dados do utilizador.';
        }
    }  
    
    //========================================================
    // POST
    //========================================================
    if($_SERVER['REQUEST_METHOD']== 'POST'){
        
        // VAI BUSCAR OS DADOS DAS TEXT'S
        $nome = $_POST['text_nome'];
        $email = $_POST['text_email'];

        // VERIFICAÇÕES - VERIFICA SE EXISTE OUTRO UTILIZADOR COM O MESMO E-MAIL
        $parametros = [
            ':id_utilizador' => $id_utilizador,
            ':email'         => $email
        ];        

        $temp = $gestor->EXE_QUERY('SELECT * FROM utilizadores
                                    WHERE id_utilizador <> :id_utilizador
                                    AND email = :email', $parametros);
        if(count($temp) != 0){
            $erro = true;
            $mensagem = 'Já existe outro utilizador com o mesmo E-mail.';
        }

        //==========================================================
        // ATUALIZA OS DADOS NA BASE DE DADOS
        if(!$erro){
            $parametros = [
                ':id_utilizador' => $id_utilizador,
                ':nome'          => $nome,
                ':email'         => $email,
                ':atualizado_em' => Datas::DataHoraAtualBD()
            ];  
            
            $gestor->EXE_NON_QUERY(
                'UPDATE utilizadores SET
                nome  = :nome,
                email = :email,
                atualizado_em = :atualizado_em
                WHERE id_utilizador = :id_utilizador',$parametros);
            
            // SUCESSO
            $sucesso = true;
            $mensagem = 'Dados atualizados com sucesso.';

            $parametros = [':id_utilizador' => $id_utilizador];
            $dados_utilizador = $gestor->EXE_QUERY('SELECT * FROM utilizadores WHERE id_utilizador = :id_utilizador', $parametros);
        }
    }
?>

<!-- ERRO DE PERMISSÃO -->
<?php if($erro_permissao) : ?>
    <?php include('../inc/sem_permissao.php') ?>
<?php else : ?>

    <!-- ERRO DE FALTA DE DADOS -->
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
    
        <!-- APRESENTA UMA MENSAGEM DE SUCESSO -->
        <?php if($sucesso): ?>
            <div class="alert alert-success text-center">
                <?php echo $mensagem ?>
            </div>
        <?php endif; ?>

        <!-- FORMULÁRIO PARA EDIÇÃO DOS DADOS DO UTILIZADOR -->
        <div class="container">
            <div class="row card mt-3 mb-3">
                <h4 class="text-center mt-4"><i class="fa fa-edit"></i> Editar Dados do Utilizador</h4>

                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="mt-3 mb-3">
                            <form action="?a=editar_utilizador&id=<?php echo $id_utilizador ?>" method="post">
                                <div class="form-group">
                                    <label>Utilizador:</label>
                                    <p><strong><?php echo $dados_utilizador[0]['utilizador'] ?></strong></p>

                                    <!-- NOME COMPLETO -->
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

                                    <!-- E-MAIL -->
                                    <div class="form-group">
                                        <label>E-mail:</label>
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