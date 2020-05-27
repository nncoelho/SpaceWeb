<?php 
    //=========================================
    // Cabeçalho da Aplicação Web
    //=========================================
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SpaceWeb</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="inc/css/web/main_web.css">
</head>
<body>
<div class="bg-white">

    <?php 
        //========================================
        // Barra de Login e Signup
        //========================================
        include_once('clientes/barra_cliente.php');
    ?>

    <!-- Cabeçalho -->
    <div class="container-fluid cabecalho">
        <a href="?a=home"><img class="logo" src="images/logo.png"></a>
    </div>