<?php 
    //=========================================
    // PERFIL - ALTERAR PASSWORD
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }

    // DEFINE O ERRO
    $erro = false;
    $sucesso = false;
    $mensagem = '';

    // VERIFICA SE FOI FEITO POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // VAI BUSCAR OS VALORES INSERIDOS NOS INPUTS
        $password_atual = $_POST['text_password_atual'];
        $password_nova_1 = $_POST['text_password_nova_1'];
        $password_nova_2 = $_POST['text_password_nova_2'];

        $gestor = new Gestor();

        //=====================================
        // VERIFICAÇÕES

        // VERIFICA SE A PASSWORD ATUAL ESTÁ CORRETA
        $parametros = [
            ':id_utilizador'    => $_SESSION['id_utilizador'],
            ':palavra_passe'    => md5($password_atual)
        ];

        $dados = $gestor->EXE_QUERY(
            'SELECT id_utilizador, palavra_passe FROM utilizadores
             WHERE id_utilizador = :id_utilizador
             AND palavra_passe = :palavra_passe',$parametros);

        if(count($dados) == 0){
            // PASSWORD ATUAL ERRADA
            $erro = true;
            $mensagem = 'A password atual não coincide.';
        }

        if(!$erro){
            // VERIFICA SE AS DUAS PASSWORDS NOVAS COINCIDEM
            if($password_nova_1 != $password_nova_2){
                $erro = true;
                $mensagem = 'A Nova Password e a sua repetição não correspondem.';
            }
        }

        // ATUALIZA A PASSWORD NA BD
        if(!$erro){
            
            $data_atualizacao = new DateTime();

            $parametros = [
                ':id_utilizador'    => $_SESSION['id_utilizador'],
                ':palavra_passe'    => md5($password_nova_1),
                ':atualizado_em'    => $data_atualizacao->format('Y-m-d H:i:s')
            ];

            $gestor->EXE_NON_QUERY(
                'UPDATE utilizadores SET
                 palavra_passe = :palavra_passe,
                 atualizado_em = :atualizado_em 
                 WHERE id_utilizador = :id_utilizador          
                ',$parametros);
            
            $sucesso = true;
            $mensagem = 'Password atualizada com sucesso.';

            // LOG
            funcoes::CriarLOG('Utilizador '.$_SESSION['nome'].' alterou a sua password.',$_SESSION['nome']);
        }
    }
?>

<!-- MENSAGENS DE ERRO E SUCESSO -->
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
            <h4 class="text-center">Alterar Password</h4>
            <hr>

            <!-- FORMULÁRIO -->
            <form action="?a=perfil_alterar_password" method="post">

                <div class="col-sm-4 offset-sm-4 justify-content-center">
                    <div class="form-group">
                        <label>Password atual:</label>
                        <input type="text" 
                               class="form-control" 
                               name="text_password_atual"
                               required title="No mínimo 3 e no máximo 20 caracteres."
                               pattern=".{3,20}"
                               >
                    </div>
                </div>

                <div class="col-sm-4 offset-sm-4 justify-content-center">
                    <div class="form-group">
                        <label>Nova Password:</label>
                        <input type="text" 
                               class="form-control" 
                               name="text_password_nova_1"
                               required title="No mínimo 3 e no máximo 20 caracteres."
                               pattern=".{3,20}"
                               >
                    </div>
                </div>

                <div class="col-sm-4 offset-sm-4 justify-content-center">
                    <div class="form-group">
                        <label>Repetir a Nova Password:</label>
                        <input type="text" 
                               class="form-control" 
                               name="text_password_nova_2"
                               required title="No mínimo 3 e no máximo 20 caracteres."
                               pattern=".{3,20}"
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