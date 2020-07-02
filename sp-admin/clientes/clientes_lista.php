<?php
    //=========================================
    // LISTAGEM DE CLIENTES
    //=========================================

    // VERIFICA A SESSÃO
    if (!isset($_SESSION['a'])) {
        exit();
    }

    // VERIFICA SE FOI DEFINIDO O CLEAR DA PESQUISA
    if(isset($_GET['clear'])){
        if(isset($_SESSION['texto_pesquisa'])){
            unset($_SESSION['texto_pesquisa']);
        }
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
    $total_clientes = 0;

    // SISTEMA DE PAGINAÇÃO
    $pagina = 1;

    if(isset($_GET['p'])){
        $pagina = $_GET['p'];
    }

    $itens_por_pagina = 10;
    $item_inicial = ($pagina * $itens_por_pagina) - $itens_por_pagina;

    if(isset($_SESSION['texto_pesquisa'])){
        // PESQUISA COM FILTRO
        $texto = $_SESSION['texto_pesquisa'];
        $parametros = [':pesquisa' => '%'.$texto.'%'];
        $clientes = $gestor->EXE_QUERY('SELECT * FROM clientes 
                                        WHERE nome LIKE :pesquisa
                                        OR email LIKE :pesquisa
                                        ORDER BY nome ASC LIMIT '.$item_inicial.','.$itens_por_pagina, $parametros);

        $total_clientes = count($gestor->EXE_QUERY('SELECT * FROM clientes 
                                                    WHERE nome LIKE :pesquisa
                                                    OR email LIKE :pesquisa
                                                    ORDER BY nome ASC', $parametros));
    } else{
        // PESQUISA SEM FILTRO
        $clientes = $gestor->EXE_QUERY('SELECT * FROM clientes ORDER BY nome ASC LIMIT '.$item_inicial.','.$itens_por_pagina);
        $total_clientes = count($gestor->EXE_QUERY('SELECT id_cliente FROM clientes'));
    }
?>

<div class="container mb-5">
    <div class="row mt-2 mb-2">
        <div class="col-sm-8 col-12 align-self-center">
            <h4><i class="fa fa-list-alt"></i> Listagem de Clientes</h4>
            <!-- MECANISMO DE PAGINAÇÃO -->
            <?php funcoes::Paginacao('?a=clientes_lista', $pagina, $itens_por_pagina, $total_clientes); ?>
        </div>
        <div class="col-sm-4 col-12 align-self-center">
            <form action="?a=clientes_lista" method="post">
                <div class="form-inline">
                    <div class="text-right">
                        <input type="text" 
                            name="text_pesquisa" 
                            class="form-control ml-5" 
                            placeholder="Pesquisa" 
                            value="<?php echo isset($_SESSION['texto_pesquisa']) ? $_SESSION['texto_pesquisa'] : ''; ?>">
                        <button class="btn btn-primary ml-1 text-center">
                            <i class="fa fa-search"></i>
                        </button>
                        <a href="?a=clientes_lista&clear=true" class="btn btn-danger ml-1text-center"><i class="fa fa-times"></i></a>
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