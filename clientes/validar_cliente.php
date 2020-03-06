<?php 
    //===========================================
    // Validação da Conta de Cliente
    //===========================================

    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    } 

    $erro = false;
    $sucesso = false;
    $mensagem = '';

    // Verifica se o valor 'v' está definido na URL
    if(!isset($_GET['v'])){
        $erro = true;
        $mensagem = "Não está definido o Código de Ativação.";
    }

    // Se 'v' está definido avança no processo
    if(!$erro){

        // Vamos buscar o Código de Ativação
        $codigo_ativacao = $_GET['v'];

        // Vamos perguntar à BD se existe um Cliente com este Código de Ativação
        $gestor = new cl_gestorBD();
        
        $parametros = [
            ':codigo_validacao' => $codigo_ativacao
        ];
        $dados = $gestor->EXE_QUERY('SELECT * FROM clientes 
                                     WHERE codigo_validacao = :codigo_validacao', $parametros);
        
        // Verificar se foi encontrado um Cliente com o Código de Ativação
        if(count($dados)==0){
            // Não foi encontrado nenhum Cliente com o Código indicado
            $erro = true;
            $mensagem = 'Não existe nenhum Cliente com esse Código de Validação.';
        }

        // Vamos verificar se 'validada' já estava como valor 1
        if(!$erro){
            if($dados[0]['validada']==1){
                $erro = true;
                $mensagem = 'Esta Conta já está Validada.';
            }
        }

        // Finalmente (ultrapassados os erros possíveis) > Validar a Conta
        if(!$erro){
            $parametros = [
                ':id_cliente'   => $dados[0]['id_cliente']
            ]; 
            $gestor->EXE_NON_QUERY('UPDATE clientes SET validada = 1
                                    WHERE id_cliente = :id_cliente', $parametros);
            
            // Informar o Cliente que a sua Conta foi Ativada
            $sucesso = true;
            $mensagem = "Conta Ativada com Sucesso.";
        }
    }
?>

<!-- Mensagens de Erro e de Sucesso -->
<?php if($erro) : ?>

   <div class="alert alert-danger text-center"><?php echo $mensagem ?></div>           

<?php elseif($sucesso) : ?>

    <div class="alert alert-success text-center"><?php echo $mensagem ?></div>           

<?php endif; ?>