<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Solo inicia la sesión si no hay una activa
} // Asegúrate de incluir esto al principio del archivo
?>
<header id="masthead" class="site-header">
    <nav id="primary-navigation" class="site-navigation">
        <div class="container">
            <div class="navbar-header">
                <img style="width: 100px; height: 90px; border-radius: 100px;" src="assets/img/Tesoros_Ocultos_logo.png">
                <a class="site-title"><span>Tesoros</span>Ocultos</a>
            </div><!-- /.navbar-header -->
            <div class="collapse navbar-collapse" id="agency-navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="index.php" data-toggle="dropdown">Inicio</a></li>
                    <li><a href="zonasArq.php">Zonas Arqueológicas</a></li>                   
                
                    <li><a href="culturas.php">Culturas</a></li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Agendar Visita<i class="fa fa-caret-down hidden-xs" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                            <li><a href="agendar.php">Nueva Reserva</a></li>
                            <li><a href="view/reservas.php">Mis Reservas</a></li>
                        </ul>
                    </li>
                    
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <!-- Mostrar cuando el usuario está autenticado -->
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa-solid fa-user fa-lg"></i><i class="fa fa-caret-down hidden-xs" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                <li><a href="view/perfil.php">Mi Perfil</a></li>
                                <li><a href="view/reservas.php">Mis Reservas</a></li>
                                <li><a href="model/cerrar_sesion.php">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Mostrar cuando el usuario NO está autenticado -->
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa-solid fa-user fa-lg"></i><i class="fa fa-caret-down hidden-xs" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                <li><a href="view/login.php">Iniciar Sesión/Registrar</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav><!-- /.site-navigation -->
</header><!-- /#masthead -->
