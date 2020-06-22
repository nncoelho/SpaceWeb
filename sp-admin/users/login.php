<?php
    //=========================================
    // LOGIN DOS UTILIZADORES
    //=========================================    
    
    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }

    $erro = true;
    $mensagem = '';
    
    // VERIFICA SE FOI FEITO UM POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        // VERIFICA SE OS DADOS DO LOGIN ESTÃO CORRETOS
        $gestor = new Gestor();

        // PREPARAÇÃO DOS PARÂMETROS
        $parametros = [
            ':utilizador'       => $_POST['text_utilizador'],
            ':palavra_passe'    => md5($_POST['text_password'])
        ];

        // PROCURA O UTILIZADOR NA BASE DE DADOS
        $dados = $gestor->EXE_QUERY(
            'SELECT * FROM utilizadores
             WHERE utilizador = :utilizador
             AND palavra_passe = :palavra_passe',$parametros);
        
        if(count($dados) == 0){
            // LOGIN INVÁLIDO
            $erro = true;
            $mensagem = 'Dados de login inválidos.';
        } else {

            // LOGIN VÁLIDO
            $erro = false;
            // INICIA A SESSÃO
            funcoes::IniciarSessao($dados);
            // LOG
            funcoes::CriarLOG('Utilizador '.$_SESSION['nome'].' fez Login.', $_SESSION['nome']);
        }
    }
?>

<?php if($erro): ?>

    <?php 
        if($mensagem!=''){
            echo '<div class="alert alert-danger text-center">'.$mensagem.'</div>';
        }
    ?>

    <div class="container-fluid">
        
        <h3 class="text-center mt-5"><i class="fa fa-users" aria-hidden="true"></i> Login de Utilizadores</h3>

        <div class="row justify-content-center">        
            <div class="col-md-4 card mt-2 p-4">

                <form action="?a=login" method="post">
                    <div class="form-group">
                        <input type="text" name="text_utilizador" class="form-control" placeholder="Utilizador">
                    </div>
                    <div class="form-group">
                        <input type="password" name="text_password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group text-center">
                        <button role="submit" class="btn btn-primary btn-size-150">Login</button>
                    </div>
                </form>

                <div class="text-center">
                    <a href="?a=recuperar_password">Recuperar Password</a>
                </div>

            </div>        
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="../index.php?a=backend" class="btn btn-secondary btn-size-100">Voltar</a>
    </div>

<?php else : ?>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4 card mt-5 p-4 text-center">
                <p>Bem-vindo(a), <strong><?php echo $dados[0]['nome'] ?></strong></p>
                <div class="text-center">
                    <a href="?a=inicio" class="btn btn-primary btn-size-200">Avançar</a>
                </div>
            </div>        
        </div>
    </div>   

<?php endif; ?>