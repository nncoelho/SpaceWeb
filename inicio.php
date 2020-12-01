<?php
//=========================================
// INICIO DO FRONTEND
//=========================================

// VERIFICA A SESSÃO
if (!isset($_SESSION['a'])) {
    exit();
}
?>

<?php if (isset($_SESSION['id_cliente']) && $_SESSION['id_cliente'] == true) : ?>
    <div class="container-fluid index-container text-center">
        <h3>Página inicial da aplicação web</h3>
        <div class="row mt-2">
            <div class="col-md-8 offset-2">
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="container-fluid index-container text-center">
        <h3>Página inicial da aplicação web</h3>
        <div class="row mt-2">
            <div class="col-md-8 offset-2">
                <!-- BOTÃO PARA ACEDER AO BACKEND -->
                <a href="?a=backend" class="btn btn-outline-primary"> Backend</a>
            </div>
        </div>
    </div>
<?php endif; ?>