<?php
    //==============================================================
    // Gestão de Utilizadores - Editar Permissões de Utilizador
    //==============================================================

    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    // Sucesso ou Erro
    $sucesso = false;
    $mensagem = '';
    
    // Verificar Permissão
    $erro_permissao = false;
    if(!funcoes::Permissao(0)){
        $erro_permissao = true;
    }

    // Verifica se id_utilizador está definido
    $id_utilizador = -1;
    if(isset($_GET['id'])){
        $id_utilizador = $_GET['id'];
    } else {
        $erro_permissao = true;
    }

    // Verifica se pode avançar (id_utilizador != 1 e != do da sessão)
    if($id_utilizador == 1 || $id_utilizador == $_SESSION['id_utilizador']){
        $erro_permissao = true;
    }
    
    // ==============================================================
    $gestor = new cl_gestorBD();
    $dados_utilizador = null;
    if(!$erro_permissao){
        // Vamos buscar os Dados do Utilizador
        $parametros = [':id_utilizador' => $id_utilizador];
        $dados_utilizador = $gestor->EXE_QUERY('SELECT * FROM utilizadores 
                                                WHERE id_utilizador = :id_utilizador', $parametros);
    }

    // ==============================================================
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // Permissões
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

        // Atualizar as Permissões na Base de Dados
        $parametros = [
            ':id_utilizador'    => $id_utilizador,
            ':permissoes'       => $permissoes_finais,
            ':atualizado_em'    => DATAS::DataHoraAtualBD()
        ];

        $gestor->EXE_NON_QUERY('UPDATE utilizadores SET 
                                permissoes = :permissoes,
                                atualizado_em = :atualizado_em
                                WHERE id_utilizador = :id_utilizador',$parametros);
        // Recarregar os Dados do Utilizador
        $parametros = [':id_utilizador' => $id_utilizador];
        $dados_utilizador = $gestor->EXE_QUERY('SELECT * FROM utilizadores 
                                                WHERE id_utilizador = :id_utilizador', $parametros);
        $sucesso = true;
        $mensagem = 'Dados atualizados com sucesso.';
    }
?>

<?php if($erro_permissao) : ?>
    <?php include('inc/sem_permissao.php') ?>
<?php else : ?>

    <!-- Mensagem de Sucesso -->
    <?php if($sucesso) :?>
    <div class="alert alert-success text-center"><?php echo $mensagem ?></div>
    <?php endif; ?>

    <div class="container">    
        <div class="row mt-3 mb-3 p-3">
            <div class="col-8 offset-2 card p-4">
                <h4 class="text-center">Editar Permissões</h4>

                <!-- Dados do Utilizador -->
                <hr>
                <p>Utilizador: <b><?php echo $dados_utilizador[0]['nome'] ?></b> </p>
                <hr>

                <!-- Caixa Permissões -->
                <form action="?a=editar_permissoes&id=<?php echo $id_utilizador ?>" method="post">
                    <div class="caixa-permissoes">                                    
                        <?php 
                            $permissoes = include('inc/permissoes.php');
                            $id=0;
                            foreach($permissoes as $permissao){ 
                        ?>
                        <div class="checkbox">
                            <label>
                                <?php 
                                    // Vamos buscar o valor da Permissão no Utilizador
                                    $ptemp = substr($dados_utilizador[0]['permissoes'], $id, 1);
                                    $checked = $ptemp == '1' ? 'checked' : '';
                                ?>                    
                                <input type="checkbox" name="check_permissao[]" id="check_permissao" value="<?php echo $id ?>" <?php echo $checked ?>>
                            
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

                    <!-- Botões -->
                    <div class="text-center mt-5">
                        <a href="?a=utilizadores_gerir" class="btn btn-primary btn-size-150">Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-size-150">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endif; ?>