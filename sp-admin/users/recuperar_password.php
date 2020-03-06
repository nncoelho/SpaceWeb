<?php
    //========================================
    // Formulário de Login
    //========================================    
    
    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    $erro = false;
    $mensagem = '';
    $mensagem_enviada = false;


    // Verificar se existe um POST
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $text_email = $_POST['text_email'];

        // Criar o objeto da Base de Dados
        $gestor = new cl_gestorBD();

        // Parametros
        $parametros = [
            ':email' => $text_email
        ];

        // Pesquisar na BD para verificar se existe Conta de Utilizador com este Email
        $dados = $gestor->EXE_QUERY('SELECT * FROM utilizadores WHERE email = :email',$parametros);

        // Verificar se foi encontrado Email
        if(count($dados) == 0){
            $erro = true;
            $mensagem = 'Não foi encontrada conta de utilizador com esse email.';
        }
        
        // No caso de não haver Erro (Foi encontrada Conta de Utilizador com o Email indicado)
        else{

            // Recuperar a Password
            $nova_password = funcoes::CriarCodigoAlfanumerico(15);

            // Enviar o Email
            $email = new emails();
            // Preparação dos Dados do Email
            $temp = [
                $dados[0]['email'],
                'spaceweb - Recuperação da password',
                '<h3>spaceweb</H3><h4>RECUPERAÇÃO DA PASSWORD</h4><p>'.$nova_password.'</p>'
            ];

            // Envio do Email
            $mensagem_enviada = $email->EnviarEmail($temp);

            // Alterar a Senha na BD
            if($mensagem_enviada){
                $id_utilizador = $dados[0]['id_utilizador'];

                $parametros = [
                    ':id_utilizador'    => $id_utilizador,
                    ':palavra_passe'    => md5($nova_password)
                ];

                $gestor->EXE_NON_QUERY(
                    'UPDATE utilizadores
                    SET palavra_passe = :palavra_passe
                    WHERE id_utilizador = :id_utilizador', $parametros);

                // LOG
                funcoes::CriarLOG('O utilizador '.$dados[0]['nome'].' solicitou recuperação da password.', $dados[0]['nome']);

            } else {
                // Aconteceu um Erro
                $erro = true;
                $mensagem = 'Atenção: O Email de recuperação não foi enviado com Sucesso. Tente novamente.';
            }
        }
    }
?>

<?php if($mensagem_enviada == false) : ?>

    <!-- Mensagem de Erro -->
    <?php if($erro): ?>
        <div class="alert alert-danger text-center">
            <?php echo $mensagem ?>
        </div>
    <?php endif; ?>

    <!-- Apresentação do Formulário -->
    <div class="container-fluid">    
        <div class="row justify-content-center">
            <div class="col-md-4 card m-3 p-3">
            
                <form action="?a=recuperar_password" method="post">                
                    <div class="text-center">
                    <h3>Recuperar Password</h3>
                    <p>Coloque aqui o seu endereço de email para recuperação da password.</p>
                    </div>
                    <div class="form-group">
                        <input type="email" name="text_email" class="form-control" placeholder="email" required>
                    </div>                
                    <div class="form-group text-center">
                        <a href="?a=inicio" class="btn btn-primary btn-size-150">Cancelar</a>
                        <button role="submit" class="btn btn-primary btn-size-150">Recuperar</button>
                    </div>
                </form>            
            </div>        
        </div>
    </div>

<?php else :?>
    
    <!-- Apresentação da mensagem de Sucesso na recuperação da Password -->
    <div class="container-fluid">    
        <div class="row justify-content-center">
            <div class="col-md-4 card m-3 p-3 text-center">
            
            <h2>Recuperação com Sucesso</h2>
            <p>A recuperação da Password foi efetuada com Sucesso.<br>Consulte a sua Caixa de Entrada do Email para conhecer a Nova Password.</p>

            <div class="text-center">
            <a href="?a=inicio" class="btn btn-primary btn-size-150">Voltar</a>
            </div>

            </div>                    
        </div>
    </div>
<?php endif; ?>