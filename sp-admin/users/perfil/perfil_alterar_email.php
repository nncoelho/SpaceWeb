<?php 
    //=========================================
    // PERFIL UTILIZADORES - ALTERAR E-MAIL
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

        // VAI BUSCAR O VALOR INSERIDO NO INPUT
        $novo_email = $_POST['text_novo_email'];
        
        $gestor = new Gestor();

        //=====================================
        // VERIFICAÇÕES

        // VERIFICA SE O NOVO E-MAIL ESTÁ A SER USADO POR OUTRO UTILIZADOR
        $parametros = [
            ':id_utilizador'    => $_SESSION['id_utilizador'],
            ':email'            => $novo_email
        ];

        $dados = $gestor->EXE_QUERY(
            'SELECT id_utilizador, email FROM utilizadores
             WHERE id_utilizador <> :id_utilizador
             AND email = :email',$parametros);

        if(count($dados) != 0){
            // OUTRO UTILIZADOR COM O MESMO E-MAIL
            $erro = true;
            $mensagem = 'Já existe outro utilizador com o mesmo E-mail.';
        }

        // ATUALIZAR O E-MAIL NA BD
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
            $mensagem = 'E-mail atualizado com sucesso.';

            // ATUALIZA O E-MAIL NA SESSÃO
            $_SESSION['email'] = $novo_email;

            // LOG
            funcoes::CriarLOG('Utilizador '.$_SESSION['nome'].' alterou o seu E-mail.',$_SESSION['nome']);
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
        <div class="col card mt-5 p-4">
            <h4 class="text-center"><i class="fa fa-at" aria-hidden="true"></i> Alterar E-mail</h4>
            <hr>

            <!-- APRESENTA O E-MAIL ATUAL -->
            <div class="text-center">E-mail atual: <strong><?php echo $_SESSION['email'] ?></strong></div>

            <hr>

            <!-- FORMULÁRIO -->
            <form action="?a=perfil_alterar_email" method="post">

                <div class="col-sm-4 offset-sm-4 justify-content-center">
                    <div class="form-group">
                        <label>Novo E-mail:</label>
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