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

        // PESQUISAR NA BD PARA VERIFICAR SE EXISTE CONTA DE UTILIZADOR COM ESTE E-MAIL
        $dados = $gestor->EXE_QUERY('SELECT * FROM utilizadores WHERE email = :email',$parametros);

        // VERIFICAR SE FOI ENCONTRADO E-MAIL
        if(count($dados) == 0){
            $erro = true;
            $mensagem = 'Não foi encontrada nenhuma conta de utilizador com esse E-mail.';
        }
        
        // NO CASO DE NÃO HAVER ERRO (FOI ENCONTRADA CONTA DE UTILIZADOR COM O E-MAIL INDICADO)
        else{

            // RECUPERAR A PASSWORD
            $nova_password = funcoes::CriarCodigoAlfanumerico(15);

            // ENVIAR O E-MAIL
            $email = new emails();

            // PREPARAÇÃO DOS DADOS DO E-MAIL
            $temp = [
                $dados[0]['email'],
                'SpaceWeb - Recuperação da Password',
                '<h3>SpaceWeb</H3><h4>Recuperação Da Password</h4><p>'.$nova_password.'</p>'
            ];

            // ENVIO DO E-MAIL
            $mensagem_enviada = $email->EnviarEmail($temp);

            // ALTERAR A SENHA NA BD
            if($mensagem_enviada){
                $id_utilizador = $dados[0]['id_utilizador'];

                $parametros = [
                    ':id_utilizador'    => $id_utilizador,
                    ':palavra_passe'    => md5($nova_password)
                ];

                // ACTUALIZAÇÃO NA BASE DE DADOS
                $gestor->EXE_NON_QUERY(
                    'UPDATE utilizadores
                    SET palavra_passe = :palavra_passe
                    WHERE id_utilizador = :id_utilizador', $parametros);

                // LOG
                funcoes::CriarLOG('O utilizador '.$dados[0]['nome'].' solicitou recuperação da password.', $dados[0]['nome']);

            } else {
                // ACONTECEU UM ERRO
                $erro = true;
                $mensagem = 'Atenção: O E-mail de recuperação não foi enviado com Sucesso. Tente novamente.';
            }
        }
    }
?>

<?php if($mensagem_enviada == false) : ?>

    <!-- MENSAGEM DE ERRO -->
    <?php if($erro): ?>
        <div class="alert alert-danger offset-3 col-6 mt-4 text-center">
            <?php echo $mensagem ?>
        </div>
    <?php endif; ?>

    <!-- APRESENTAÇÃO DO FORMULÁRIO -->
    <div class="container-fluid">    
        <div class="row justify-content-center">
            <div class="col-md-4 card mt-5 p-3">
            
                <form action="?a=recuperar_password" method="post">                
                    <div class="text-center">
                        <h3 class="mt-3 mb-4"><i class="fa fa-unlock-alt"></i> Recuperar Password</h3>
                        <p>Coloque aqui o seu endereço de E-mail<br>para seguir as instruções de recuperação da password.</p>
                    </div>
                    <div class="form-group">
                        <input type="email" name="text_email" class="form-control" placeholder="E-mail" required>
                    </div>                
                    <div class="form-group text-center">
                        <a href="?a=inicio" class="btn btn-primary btn-size-150 mt-2 mb-2">Cancelar</a>
                        <button role="submit" class="btn btn-primary btn-size-150 mt-2 mb-2">Recuperar</button>
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
                <p>A recuperação da password foi efetuada com sucesso. Consulte a sua caixa de correio electrónico para ter acesso á sua nova password.</p>

                <div class="text-center">
                    <a href="?a=inicio" class="btn btn-primary btn-size-150">Voltar</a>
                </div>
            </div>                    
        </div>
    </div>

<?php endif; ?>