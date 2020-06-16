<?php 
    //=========================================
    // CABEÇALHO PRINCIPAL DA APLICAÇÃO WEB
    //=========================================
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SpaceWeb</title>
    <!-- BOOTSTRAP - FONTAWESOME - CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.1/js/all.min.js"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="inc/css/web/main_web.css">
</head>
<body>
<div class="bg-white">

    <?php 
        //=====================================
        // BARRA DE CLIENTES
        //=====================================
        include_once('clientes/barra_cliente.php');
    ?>

    <!-- CABEÇALHO E LOGOTIPO -->
    <div class="container-fluid cabecalho">
        <a href="?a=home"><img class="logo" src="images/logo.png"></a>
    </div>