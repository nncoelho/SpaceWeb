<?php
    //=========================================
    // LISTAGEM DE CLIENTES
    //=========================================

    // VERIFICA A SESSÃO
    if (!isset($_SESSION['a'])) {
        exit();
    }

    // CARREGA OS DADOS DOS CLIENTES
    $gestor = new Gestor();
    $clientes = $gestor->EXE_QUERY('SELECT * FROM clientes ORDER BY nome ASC');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">

        <h4 class="text-center p-3">Listagem de Clientes</h4>

        <table id="tabela" class="table">
            <thead class="thead-dark">
                <th>Nome:</th>
                <th>Email:</th>
                <th>Utilizador:</th>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente) : ?>
                    <tr>
                        <td><?php echo $cliente['nome'] ?></td>
                        <td><?php echo $cliente['email'] ?></td>
                        <td><?php echo $cliente['utilizador'] ?></td>
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
</body>
</html>