<?php
    //=========================================
    // FORMULÁRIO DE RECUPERAÇÃO DA PASSWORD
    //=========================================   
    
    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }

    $erro = false;
    $mensagem = '';
    $mensagem_enviada = false;


    // VERIFICA SE EXISTE UM POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $text_email = $_POST['text_email'];

        // CRIA O OBJETO DA BASE DE DADOS
        $gestor = new Gestor();

        // PARAMETROS
        $parametros = [
            ':email' => $text_email
        ];

        // PESQUISAR NA BD PARA VERIFICAR SE EXISTE CONTA DE UTILIZADOR COM ESTE EMAIL
        $dados = $gestor->EXE_QUERY('SELECT * FROM utilizadores WHERE email = :email',$parametros);

        // VERIFICAR SE FOI ENCONTRADO EMAIL
        if(count($dados) == 0){
            $erro = true;
            $mensagem = 'Não foi encontrada conta de utilizador com esse email.';
        }
        
        // NO CASO DE NÃO HAVER ERRO (FOI ENCONTRADA CONTA DE UTILIZADOR COM O EMAIL INDICADO)
        else{

            // RECUPERAR A PASSWORD
            $nova_password = funcoes::CriarCodigoAlfanumerico(15);

            // ENVIAR O EMAIL
            $email = new emails();
            // PREPARAÇÃO DOS DADOS DO EMAIL
            $temp = [
                $dados[0]['email'],
                'Spaceweb - Recuperação da password',
                '<h3>Spaceweb</H3><h4>Recuperação Da Password</h4><p>'.$nova_password.'</p>'
            ];

            // ENVIO DO EMAIL
            $mensagem_enviada = $email->EnviarEmail($temp);

            // ALTERAR A SENHA NA BD
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
                // ACONTECEU UM ERRO
                $erro = true;
                $mensagem = 'Atenção: O Email de recuperação não foi enviado com Sucesso. Tente novamente.';
            }
        }
    }
?>

<?php if($mensagem_enviada == false) : ?>

    <!-- MENSAGEM DE ERRO -->
    <?php if($erro): ?>
        <div class="alert alert-danger text-center">
            <?php echo $mensagem ?>
        </div>
    <?php endif; ?>

    <!-- APRESENTAÇÃO DO FORMULÁRIO -->
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
    
    <!-- APRESENTAÇÃO DA MENSAGEM DE SUCESSO NA RECUPERAÇÃO DA PASSWORD -->
    <div class="container-fluid">    
        <div class="row justify-content-center">
            <div class="col-md-6 card m-3 p-5 text-center">
            
            <h3>Recuperação concluida com Sucesso</h3>
            <p>A recuperação da password foi efetuada com sucesso. Consulte a sua caixa de entrada do email para conhecer a sua nova password.</p>

            <div class="text-center">
            <a href="?a=inicio" class="btn btn-primary btn-size-150">Voltar</a>
            </div>

            </div>                    
        </div>
    </div>
<?php endif; ?>