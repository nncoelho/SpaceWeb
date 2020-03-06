<?php
    //========================================================
    // Gestão de Utilizadores - Adicionar Novo Utilizador
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
    
    $gestor = new cl_gestorBD();
    $erro = false;
    $sucesso = false;
    $mensagem = '';

    //==================================================================================
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // Vai buscar os valores do formulário
        $utilizador =       $_POST['text_utilizador'];
        $password  =        $_POST['text_password'];
        $nome_completo =    $_POST['text_nome'];
        $email =            $_POST['text_email'];

        // Permissoes
        $total_permissoes = (count(include('inc/permissoes.php')));
        $permissoes = [];
        if(isset($_POST['check_permissao'])){
            $permissoes = $_POST['check_permissao'];
        }
        
        $permissoes_finais = '';
        for ($i=0; $i < 100; $i++) { 

            if($i<$total_permissoes){
                if(in_array($i, $permissoes)){
                    $permissoes_finais.='1';        
                } else {
                    $permissoes_finais.='0';
                }
            } else {
                $permissoes_finais.='1';
            }        
        }
        
        //==========================================================
        // Verifica os Dados na Base de Dados

        //==========================================================
        // Verifica se existe Utilizador com Nome igual
        $parametros = [
            ':utilizador' => $utilizador
        ];

        $dtemp = $gestor->EXE_QUERY('SELECT utilizador 
                                     FROM utilizadores
                                     WHERE utilizador = :utilizador', $parametros);
        if(count($dtemp)!=0){
            $erro = true;
            $mensagem = 'Já existe um utilizador com o mesmo nome.';
        }

        //==========================================================
        // Verifica se existe outro Utilizador com o mesmo Email
        if(!$erro){
            $parametros = [
                ':email' => $email
            ];

            $dtemp = $gestor->EXE_QUERY('SELECT email 
                                         FROM utilizadores
                                         WHERE email = :email', $parametros);
            if(count($dtemp)!=0){
                $erro = true;
                $mensagem = 'Já existe outro utilizador com o mesmo email.';
            }                          
        }
        
        //==========================================================
        // Guardar na Base de Dados
        if(!$erro){
            $parametros = [
                ':utilizador'       => $utilizador,
                ':palavra_passe'    => md5($password),
                ':nome'             => $nome_completo,
                ':email'            => $email,
                ':permissoes'       => $permissoes_finais,
                ':criado_em'        => DATAS::DataHoraAtualBD(),
                ':atualizado_em'    => DATAS::DataHoraAtualBD()
            ];

            $gestor->EXE_NON_QUERY('
                INSERT INTO utilizadores
                    (utilizador, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
                VALUES
                    (:utilizador, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',$parametros);
            
            // Enviar o Email para o Novo Utilizador
            $mensagem = [
                $email,
                'SpaceWeb - Criação de Nova Conta de Utilizador',
                "<p>Foi criada a Nova Conta de Utilizador com os seguintes dados:<p><p>Utilizador: $utilizador <p><p>Password: $password </p>"
            ];
            $mail = new emails();
            $mail->EnviarEmail($mensagem);
            
            // Apresentar um Alerta de Sucesso
            echo '<div class="alert alert-success text-center">Novo utilizador adicionado com sucesso.</div>';
        }
    }    
?>

<!-- Apresenta o Erro no caso de existir -->
<?php 
    if($erro){
        echo '<div class="alert alert-danger text-center">'.$mensagem.'</div>';
    }
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8 card m-3 p-3">
            <h4 class="text-center">Adicionar Novo Utilizador</h4>
            <hr>
            <!-- Formulário para Adicionar Novo Utilizador -->
            <form action="?a=utilizadores_adicionar" method="post">
            
                <!-- Utilizador -->
                <div class="form-group">
                    <label>Utilizador:</label>
                    <input type="text"
                        name="text_utilizador"
                        class="form-control"
                        pattern=".{3,50}"
                        title="Entre 3 e 50 caracteres."
                        required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label>Password:</label>
                    <div class="row">                    
                        <div class="col">
                            <input type="text"
                                name="text_password"
                                id="text_password"
                                class="form-control"
                                pattern=".{3,30}"
                                title="Entre 3 e 30 caracteres."
                                required>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary" onclick="gerarPassword(10)">Gerar Password</button>
                        </div>
                    </div>
                </div>

                <!-- Nome Completo -->
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text"
                        name="text_nome"
                        class="form-control"
                        pattern=".{3,50}"
                        title="Entre 3 e 50 caracteres."
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
                        required>
                </div>

                <div class="text-center">
                    <a href="?a=utilizadores_gerir" class="btn btn-primary btn-size-150">Cancelar</a>
                    <button class="btn btn-primary btn-size-150">Criar Utilizador</button>
                </div>
                <hr>
                <div class="text-center m-3">
                    <button type="button" 
                            class="btn btn-primary btn-size-150"
                            data-toggle="collapse" 
                            data-target="#caixa_permissoes">Definir Permissões</button>
                </div>

                <!-- Caixa Permissões -->
                <div class="collapse" id="caixa_permissoes">
                    <div class="card p-3 caixa-permissoes">
                        <?php 
                            $permissoes = include('inc/permissoes.php');
                            $id=0;
                            foreach($permissoes as $permissao){ 
                        ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="check_permissao[]" id="check_permissao" value="<?php echo $id ?> ">
                                <span class="permissao-titulo"><?php echo $permissao['permissao'] ?></span>
                            </label>
                            <p class="permissao-sumario"><?php echo $permissao['sumario'] ?></p>
                        </div>
                        <?php $id++; } ?>
                    
                        <!-- Todas | Nenhuma -->
                        <div>
                            <a href="#" onclick="checks(true); return false">Todas</a> | <a href="#" onclick="checks(false); return false">Nenhumas</a>
                        </div>
                    </div>
                </div>

            </form>
        </div>        
    </div>
</div>