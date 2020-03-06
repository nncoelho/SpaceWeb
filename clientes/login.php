<?php     
    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    } 

    $erro = false;
    $mensagem = '';

    // Verifica se os Dados de Login estão corretos
    $utilizador = $_POST['text_utilizador'];
    $senha = md5($_POST['text_senha']);

    // Prepara a Query para o Login
    $gestor = new cl_gestorBD();
    $parametros = [
        ':utilizador'       => $utilizador,
        ':palavra_passe'    => $senha
    ];
    
    $dados = $gestor->EXE_QUERY('
        SELECT * FROM clientes
        WHERE utilizador = :utilizador
        AND palavra_passe = :palavra_passe
    ',$parametros);

    // Verifica se existe Dados
    if(count($dados) == 0){
        // Não foi encontrado nenhum Cliente com os Dados indicados
        $erro = true;
        $mensagem = "Não existe Conta de cliente.";
    } else {
        // Caso exista um Cliente vamos verificar se a Conta está Validada
        if($dados[0]['validada'] == 0){
            $erro = true;
            $mensagem = 'Atenção: Verifique a sua Caixa de Correio Eletrónico, para poder Validar a sua Conta de Cliente.';
        }
    }

    if(!$erro){
        // Login efetuado com Sucesso
        funcoes::IniciarSessaoCliente($dados);
    }
?>

<?php if($erro):?>
    <div class="alert alert-danger">
        <p><?php echo $mensagem ?></p>
    </div>
<?php else :?>
    
<div class="container-fluid">
    
    <div class="row">
        <div class="col-4 offset-4 mt-5 mb-5 card p-4 text-center">
            <p>Bem-vindo(a), <b><?php echo $dados[0]['nome'] ?></b>.</p>
            <a href="?a=home" class="btn btn-primary">Ok</a>
        </div>
    </div>

</div>

<?php endif;?>