<?php     
    // Verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    if(!funcoes::VerificarLoginCliente()){
        exit();
    }

    $erro = false;
    $sucesso = false;
    $mensagem = '';

    // =========================================
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $p = $_GET['p'];
        $id_cliente = $_SESSION['id_cliente'];
        $gestor = new cl_gestorBD();
        $data = new DateTime();

        switch ($p) {

            case 1:
                // Alterar o Nome do Cliente
                $parametros = [
                    ':id_cliente' => $id_cliente,
                    ':nome'       => $_POST['text_nome']
                ];

                $dados = $gestor->EXE_QUERY('SELECT id_cliente, nome FROM clientes
                                             WHERE id_cliente <> :id_cliente
                                             AND nome = :nome', $parametros);
                if(count($dados) != 0){
                    // Foi encontrado outro Cliente com o mesmo Nome
                    $erro = true;
                    $mensagem = 'Já existe outro Cliente com o mesmo Nome.';
                } else {

                    $parametros = [
                        ':id_cliente'       => $id_cliente,
                        ':nome'             => $_POST['text_nome'],
                        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
                    ];

                    $gestor->EXE_NON_QUERY('UPDATE clientes SET
                                            nome = :nome,
                                            atualizado_em = :atualizado_em
                                            WHERE id_cliente = :id_cliente',$parametros);
                    $sucesso = true;
                    $mensagem = 'Nome alterado com Sucesso.';
                    
                }
            break;
        
            case 2:
                // Alterar o Email do Cliente
                $text_email_1 = $_POST['text_email'];
                $text_email_2 = $_POST['text_email_repetir'];

                // Verifica se os Emails introduzidos correspondem
                if($text_email_1 != $text_email_2){
                    $erro = true;
                    $mensagem = 'Os Emails não correspondem.';
                }

                // Verifica se já existe outro Cliente com o mesmo Email
                if(!$erro){                    
                    $parametros = [
                        ':id_cliente'   => $id_cliente,
                        ':email'        => $text_email_1
                    ];

                    $dados = $gestor->EXE_QUERY('SELECT id_cliente, email FROM clientes
                                                 WHERE id_cliente <> :id_cliente
                                                 AND email = :email', $parametros);
                    if(count($dados) != 0){
                        $erro = true;
                        $mensagem = 'Já existe outro Cliente com o mesmo Email.';
                    }
                }

                // Atualização do Email do Cliente na Base de Dados
                if(!$erro){ 
                    $parametros = [
                        ':id_cliente'   => $id_cliente,
                        ':email'        => $text_email_1,
                        ':atualizado_em'=> $data->format('Y-m-d H:i:s')
                    ];

                    $gestor->EXE_NON_QUERY('UPDATE clientes SET
                                            email = :email,
                                            atualizado_em = :atualizado_em
                                            WHERE id_cliente = :id_cliente',$parametros);
                    $sucesso = true;
                    $mensagem = 'Email do Cliente alterado com Sucesso.';
                }
            break;
            
            case 3:
                // Alterar a senha do Cliente
                $text_senha_atual = $_POST['text_senha_atual'];
                $text_senha_nova = $_POST['text_senha_nova'];
                $text_senha_nova_1 = $_POST['text_senha_nova_1'];
                
                // Verificar se a Senha atual é a mesma da Base de Dados
                $parametros = [
                    ':id_cliente'           => $id_cliente,
                    ':palavra_passe'        => md5($text_senha_atual)
                ];
                
                $dados = $gestor->EXE_QUERY('SELECT id_cliente, palavra_passe FROM clientes
                                             WHERE id_cliente = :id_cliente 
                                             AND palavra_passe = :palavra_passe', $parametros);
                if(count($dados)==0){
                    // Existe um erro - A Senha não é igual à que se encontra na BD
                    $erro = true;
                    $mensagem = 'Senha atual não corresponde.';
                }

                // Verificar se a nova Senha e Senha repetida são iguais
                if(!$erro){
                    if($text_senha_nova != $text_senha_nova_1){
                        // As Senhas novas não correspondem
                        $erro = true;
                        $mensagem = 'As Senhas novas não correspondem.';
                    }
                }   

                // Atualizar nova Senha na Base de Dados
                if(!$erro){
                    $parametros = [
                        ':id_cliente'   =>$id_cliente,
                        ':palavra_passe'=> md5($text_senha_nova),
                        ':atualizado_em'=> $data->format('Y-m-d H:i:s')
                    ];

                    $gestor->EXE_NON_QUERY('UPDATE clientes SET
                                            palavra_passe = :palavra_passe,
                                            atualizado_em = :atualizado_em
                                            WHERE id_cliente = :id_cliente',$parametros);
                    $sucesso = true;
                    $mensagem = 'Senha alterada com Sucesso.';
                }
            break;            
        }
    }

    // Vamos buscar os dados do cliente
    $parametros = [
        ':id_cliente' => $_SESSION['id_cliente']
    ];
    $gestor = new cl_gestorBD();
    $dados_cliente = $gestor->EXE_QUERY('SELECT * FROM clientes 
                                         WHERE id_cliente = :id_cliente', 
                                         $parametros);  
    $dados = $dados_cliente[0]; // Passar os Dados todos para um Array unidimensional
?>

<!-- Mensagem de Erro -->
<?php if($erro):?>
    <div class="alert alert-danger text-center">
        <p><?php echo $mensagem ?></p>
    </div>
<?php endif;?>

<!-- Mensagem de Sucesso -->
<?php if($sucesso):?>
    <div class="alert alert-success text-center">
        <p><?php echo $mensagem ?></p>
    </div>
<?php endif;?>

<div class="container-fluid perfil">

    <div class="container pt-5 pb-5">

        <h3 class="text-center mb-5">Editar Perfil de Cliente</h3>

        <div class="row">

            <div class="col-sm-6 offset-sm-3 col-12">

                <div id="accordion">

                    <!-- Alterar Utilizador -->
                    <div class="card">
                        <div class="card-header" id="caixa_utilizador">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#t_1" aria-expanded="true" 
                                    aria-controls="collapseOne">Alterar Nome do Utilizador
                                </button>
                            </h5>
                        </div>

                        <div id="t_1" class="collapse show" aria-labelledby="caixa_utilizador" data-parent="#accordion">
                            <div class="card-body">
                        
                                <!-- Formulário para alterar o Nome do Utilizador -->
                                Nome atual: <b><?php echo $dados['nome'] ?></b>

                                <form action="?a=perfil&p=1" method="post" class="mt-3">
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control"
                                            name="text_nome" 
                                            placeholder="Novo nome" 
                                            required>
                                    </div>
                                    <div class="text-right">
                                        <input type="submit" value="Alterar" class="btn btn-primary">
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <!-- Alterar Email -->
                    <div class="card">
                        <div class="card-header" id="caixa_email">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#t_2" 
                                    aria-expanded="false" aria-controls="collapseTwo">Alterar Email
                                </button>
                            </h5>
                        </div>
                        <div id="t_2" class="collapse" aria-labelledby="caixa_email" data-parent="#accordion">
                            <div class="card-body">
                                
                                <!-- Formulário para alterar o Email -->
                                Email atual: <b><?php echo $dados['email'] ?></b>

                                <form action="?a=perfil&p=2" method="post" class="mt-3">
                                    <div class="form-group">
                                        <input type="email"
                                            class="form-control"
                                            name="text_email" 
                                            placeholder="Novo email" 
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <input type="email"
                                            class="form-control"
                                            name="text_email_repetir" 
                                            placeholder="Repetir novo email" 
                                            required>
                                    </div>

                                    <div class="text-right">
                                        <input type="submit" value="Alterar" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Alterar Senha -->
                    <div class="card">
                        <div class="card-header" id="caixa_senha">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#t_3" 
                                    aria-expanded="false" aria-controls="collapseThree">Alterar Senha
                                </button>
                            </h5>
                        </div>
                        <div id="t_3" class="collapse" aria-labelledby="caixa_senha" data-parent="#accordion">
                            <div class="card-body">
                            
                                <!-- Formulário para alterar a Senha -->
                                <form action="?a=perfil&p=3" method="post" class="mt-3">
                                    <div class="form-group">
                                        <input type="password"
                                            class="form-control"
                                            name="text_senha_atual" 
                                            placeholder="Senha atual" 
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password"
                                            class="form-control"
                                            name="text_senha_nova" 
                                            placeholder="Nova senha" 
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password"
                                            class="form-control"
                                            name="text_senha_nova_1" 
                                            placeholder="Repetir a nova senha" 
                                            required>
                                    </div>

                                    <div class="text-right">
                                        <input type="submit" value="Alterar" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>