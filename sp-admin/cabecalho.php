<?php
//========================================
// CABEÇALHO DO BACKEND
//========================================
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SpaceWeb</title>
    <!-- CSS - BOOTSTRAP - FONTAWESOME -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />
    <link rel="stylesheet" href="../inc/css/admin/main.css">
</head>

<body>
    <div class="bg-white">
        <?php
        //=====================================
        // BARRA DE UTILIZADOR
        //=====================================
        include_once('users/barra_utilizador.php');
        ?>
        <!-- CABEÇALHO E LOGOTIPO -->
        <div class="container-fluid cabecalho">
            <a href="../index.php?a=backend"><img class="logo" src="../images/logo.png"></a>
        </div>