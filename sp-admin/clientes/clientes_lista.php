<?php
    //=========================================
    // LISTAGEM DE CLIENTES
    //=========================================

    // VERIFICA A SESSÃO
    if (!isset($_SESSION['a'])) {
        exit();
    }

    // VERIFICA SE EXISTIU UM POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['text_pesquisa'] != ''){
            $_SESSION['texto_pesquisa'] = $_POST['text_pesquisa'];
        }
    }

    // CARREGA OS DADOS DOS CLIENTES
    $gestor = new Gestor();
    $clientes = null;

    if(isset($_SESSION['texto_pesquisa'])){
        // PESQUISA COM FILTRO
        $texto = $_SESSION['texto_pesquisa'];
        

    } else{
        // PESQUISA SEM FILTRO
        $clientes = $gestor->EXE_QUERY('SELECT * FROM clientes ORDER BY nome ASC');
    }

    $clientes = $gestor->EXE_QUERY('SELECT * FROM clientes ORDER BY nome ASC');
?>

<div class="container">
    <div class="row mt-3">
        <div class="col-sm-8 col-12">
            <h4 class="p-2"><i class="fa fa-list-alt"></i> Listagem de Clientes</h4>
        </div>
        <div class="col-sm-4 col-12 align-self-center">
            <form action="?a=clientes_lista" method="post">
                <div class="form-inline">
                    <div class="text-right">
                        <input type="text" 
                            name="text_pesquisa" 
                            class="form-control ml-4" 
                            placeholder="Pesquisa" 
                            value="<?php echo isset($_SESSION['texto_pesquisa']) ? $_SESSION['texto_pesquisa'] : ''; ?>">
                        <button class="btn btn-primary ml-2 text-center">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table id="tabela" class="table table-striped">
        <thead class="thead-dark">
            <th>Nome:</th>
            <th>E-mail:</th>
            <th>Utilizador:</th>
            <th class="text-center">Ações:</th>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <!-- NOME -->
                    <td>
                        <a href="?a=clientes_dados&id=<?php echo $cliente['id_cliente'] ?>">
                            <?php echo $cliente['nome'] ?>
                        </a>
                    </td>
                    <!-- E-MAIL -->
                    <td>
                        <a href="mailto:<?php echo $cliente['email'] ?>">
                            <?php echo $cliente['email'] ?>
                        </a>
                    </td>
                    <!-- UTILIZADOR -->
                    <td>
                        <?php echo $cliente['utilizador'] ?>
                    </td>
                    <!-- AÇÕES -->
                    <td class="text-center">
                        <a href="?a=clientes_eliminar&id=<?php echo $cliente['id_cliente']?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#tabela').DataTable();
    });
</script>