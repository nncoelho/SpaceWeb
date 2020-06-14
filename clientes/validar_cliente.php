<?php 
    //=========================================
    // VALIDAÇÃO DA CONTA DE CLIENTE
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    } 

    $erro = false;
    $sucesso = false;
    $mensagem = '';

    // VERIFICA SE O VALOR 'V' ESTÁ DEFINIDO NA URL
    if(!isset($_GET['v'])){
        $erro = true;
        $mensagem = "Não está definido o Código de Ativação.";
    }

    // SE 'V' ESTÁ DEFINIDO AVANÇA NO PROCESSO
    if(!$erro){

        // VAI BUSCAR O CÓDIGO DE ATIVAÇÃO
        $codigo_ativacao = $_GET['v'];

        // PERGUNTA À BD SE EXISTE UM CLIENTE COM ESTE CÓDIGO DE ATIVAÇÃO
        $gestor = new Gestor();
        
        $parametros = [
            ':codigo_validacao' => $codigo_ativacao
        ];
        $dados = $gestor->EXE_QUERY('SELECT * FROM clientes 
                                     WHERE codigo_validacao = :codigo_validacao', $parametros);
        
        // VERIFICA SE FOI ENCONTRADO UM CLIENTE COM O CÓDIGO DE ATIVAÇÃO
        if(count($dados)==0){
            // NÃO FOI ENCONTRADO NENHUM CLIENTE COM O CÓDIGO INDICADO
            $erro = true;
            $mensagem = 'Não existe nenhum Cliente com esse Código de Validação.';
        }

        // VERIFICA SE 'VALIDADA' JÁ ESTAVA COM O VALOR 1
        if(!$erro){
            if($dados[0]['validada']==1){
                $erro = true;
                $mensagem = 'Esta Conta já está Validada.';
            }
        }

        // FINALMENTE (ULTRAPASSADOS OS ERROS POSSÍVEIS) > VALIDAR A CONTA
        if(!$erro){
            $parametros = [
                ':id_cliente'   => $dados[0]['id_cliente']
            ]; 
            $gestor->EXE_NON_QUERY('UPDATE clientes SET validada = 1
                                    WHERE id_cliente = :id_cliente', $parametros);
            
            // INFORMAR O CLIENTE QUE A SUA CONTA FOI ATIVADA
            $sucesso = true;
            $mensagem = "Conta Validada e Ativada com Sucesso.";
        }
    }
?>

<!-- MENSAGENS DE ERRO E DE SUCESSO -->
<?php if($erro) : ?>

   <div class="alert alert-danger text-center"><?php echo $mensagem ?></div>           

<?php elseif($sucesso) : ?>

    <div class="alert alert-success text-center"><?php echo $mensagem ?></div>           

<?php endif; ?>