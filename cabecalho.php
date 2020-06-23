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
    <!-- CSS - BOOTSTRAP - FONTAWESOME -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="inc/css/web/main_web.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
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
        <a href="?a=inicio"><img class="logo" src="images/logo.png"></a>
    </div>