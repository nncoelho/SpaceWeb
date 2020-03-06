<?php 
    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    } 
?>

<!-- Barra do Cliente -->
<div class="container-fluid barra-cliente">
    <div class="text-right">

        <!-- Cliente Logado -->
        <?php if(funcoes::VerificarLoginCliente()): ?>

            <i class="fas fa-user mr-2"></i><?php echo $_SESSION['nome_cliente'] ?>

            <!-- Dropdown Menu -->
            <div class="dropdown d-inline">
                <button class="btn btn-secondary ml-2 dropdown-toggle" type="button" 
                    id="d1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog"></i> 
                </button>
                <div class="dropdown-menu" aria-labelledby="d1">
                    <a class="dropdown-item" href="?a=perfil">Acesso ao Perfil</a>
                    <div class="dropdown-divider"></div>                                    
                    <a class="dropdown-item" href="?a=logout">Logout</a>
                </div>
            </div>

        <?php else :?>

        <!-- Cliente Não Logado -->
        <div class="dropdown d-inline">

            <!-- Interruptor -->
            <a href="" class="mr-3" id="dropdownMenuButton" data-toggle="dropdown" 
            aria-haspopup="true" aria-expanded="false"><i class="fas fa-sign-in-alt"></i> Login</a>|
            
            <!-- Caixa -->
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <div class="p-3">
                    <form action="?a=login" method="post">
                        <input type="text" 
                               class="form-control" 
                               name="text_utilizador"
                               placeholder="Utilizador"
                               required
                               patter=".{3,20}",
                               title="Entre 3 e 20 caracteres."
                               >
                        <input type="password"
                               class="form-control mt-3" 
                               name="text_senha"
                               placeholder="Senha"
                               required
                               patter=".{3,20}",
                               title="Entre 3 e 20 caracteres."
                               >
                        <div class="text-center mt-2">
                            <a href="">Esqueceu-se da Senha?</a>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary btn-size-100 mt-3">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="d-inline">
            <a href="?a=signup" class="ml-3"><i class="fas fa-user-plus"></i> Signup</a>
        </div>

        <?php endif; ?>

    </div>
</div>