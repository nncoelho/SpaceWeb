<?php 
    //=========================================
    // LOGIN DOS CLIENTES
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    } 

    $erro = false;
    $mensagem = '';

    // VERIFICA SE OS DADOS DE LOGIN ESTÃO CORRETOS
    $utilizador = $_POST['text_utilizador'];
    $senha = md5($_POST['text_senha']);

    // PREPARA A QUERY PARA O LOGIN
    $gestor = new Gestor();

    $parametros = [
        ':utilizador'       => $utilizador,
        ':palavra_passe'    => $senha
    ];
    
    $dados = $gestor->EXE_QUERY('
        SELECT * FROM clientes
        WHERE utilizador = :utilizador
        AND palavra_passe = :palavra_passe',
    $parametros);

    // VERIFICA SE EXISTE DADOS
    if(count($dados) == 0){

        // NÃO FOI ENCONTRADO NENHUM CLIENTE COM OS DADOS INDICADOS
        $erro = true;
        $mensagem = "Não existe conta de cliente com os dados indicados.";
    } else {
        // CASO EXISTA UM CLIENTE VERIFICA SE A CONTA ESTÁ VALIDADA
        if($dados[0]['validada'] == 0){
            $erro = true;
            $mensagem = 'Atenção: Verifique a sua caixa de correio eletrónico, para poder validar a sua conta de cliente.';
        }
    }

    if(!$erro){
        // LOGIN COM SUCESSO
        funcoes::IniciarSessaoCliente($dados);
    }
?>

<!-- MENSAGENS DE ERRO E DE BOAS VINDAS DO LOGIN -->
<?php if($erro):?>

    <div class="alert alert-danger text-center">
        <?php echo $mensagem ?>
    </div>

<?php else :?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-4 offset-4 mt-5 mb-5 card p-4 text-center">
                <p>Bem-vindo(a), <b><?php echo $dados[0]['nome'] ?></b>.</p>
                <div class="text-center">
                    <a href="?a=inicio" class="btn btn-primary btn-size-150">Ok</a>
                </div>
            </div>
        </div>
    </div>
    
<?php endif;?>