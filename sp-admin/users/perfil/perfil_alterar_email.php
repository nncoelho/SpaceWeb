<?php 
    //=========================================
    // Perfil - Alterar Email
    //=========================================

    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    // Define o erro
    $erro = false;
    $sucesso = false;
    $mensagem = '';

    // Verifica se foi feito POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // Vai buscar o valor inserido no Input
        $novo_email = $_POST['text_novo_email'];
        
        $gestor = new cl_gestorBD();

        //=====================================
        // Verificações

        // Verifica se o novo Email está a ser usado por outro Utilizador
        $parametros = [
            ':id_utilizador'    => $_SESSION['id_utilizador'],
            ':email'            => $novo_email
        ];

        $dados = $gestor->EXE_QUERY(
            'SELECT id_utilizador, email FROM utilizadores
             WHERE id_utilizador <> :id_utilizador
             AND email = :email',$parametros);

        if(count($dados) != 0){
            // Outro utilizador com o mesmo Email
            $erro = true;
            $mensagem = 'Já existe outro Utilizador com o mesmo Email.';
        }

        // Atualizar o Email na BD        
        if(!$erro){
            
            $data_atualizacao = new DateTime();

            $parametros = [
                ':id_utilizador'    => $_SESSION['id_utilizador'],
                ':email'            => $novo_email,
                ':atualizado_em'    => $data_atualizacao->format('Y-m-d H:i:s')
            ];

            $gestor->EXE_NON_QUERY(
                'UPDATE utilizadores SET
                 email = :email,
                 atualizado_em = :atualizado_em 
                 WHERE id_utilizador = :id_utilizador          
                ',$parametros);
            
            $sucesso = true;
            $mensagem = 'Email atualizado com sucesso.';

            // Atualiza o Email na Sessão
            $_SESSION['email'] = $novo_email;

            // LOG
            funcoes::CriarLOG('Utilizador '.$_SESSION['nome'].' alterou o seu email.',$_SESSION['nome']);
        }
    }
?>

<!-- Mensagens de Erro e Sucesso -->
<?php if($erro) : ?>
    <div class="alert alert-danger text-center">
        <?php echo $mensagem ?>
    </div>
<?php endif; ?>

<?php if($sucesso) : ?>
    <div class="alert alert-success text-center">
        <?php echo $mensagem ?>
    </div>
<?php endif; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col card m-3 p-3">
            <h4 class="text-center">Alterar Email</h4>
            <hr>

            <!-- Apresenta o Email atual -->
            <div class="text-center">Email atual: <strong><?php echo $_SESSION['email'] ?></strong></div>

            <hr>

            <!-- Formulário -->
            <form action="?a=perfil_alterar_email" method="post">

                <div class="col-sm-4 offset-sm-4 justify-content-center">
                    <div class="form-group">
                        <label>Novo email:</label>
                        <input type="email" 
                               class="form-control" 
                               name="text_novo_email"
                               required title="No mínimo 5 e no máximo 50 caracteres."
                               pattern=".{5,50}"
                               >
                    </div>
                </div>

                <div class="text-center">
                    <a href="?a=perfil" class="btn btn-primary btn-size-150">Voltar</a>
                    <button role="submit" class="btn btn-primary btn-size-150">Alterar</button>                    
                </div>
            </form>
        </div>        
    </div>
</div>