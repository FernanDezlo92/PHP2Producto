<!-- 
<header>
    <a href="/">LoginAPP</a>
</header>
-->


<div class="section">
    <nav class="navbar navbar-expand-sm bg-body-secondary">
        <div class="container-fluid" style="width: 80%;">
            <a class="navbar-brand" href="/views/main.php" style="font-family: 'Shantell Sans';">DevBackend</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBar" aria-controls="navBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navBar">
                <ul class="navbar-nav me-auto mb-2 mb-sm-0">
                    <?php 
                        if ($tipoUsuario->getId_tipo_usuario() == 1) {
                            echo ("<li class=\"nav-item dropdown\">
                                        <a class=\"nav-link dropdown-toggle\" href=\"#\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">Administración</a>
                                        <ul class=\"dropdown-menu\">
                                            <li><a class=\"dropdown-item\" href=\"/views/actos.php\">Actos</a></li>
                                            <li><a class=\"dropdown-item\" href=\"/views/usuarios.php\">Usuarios</a></li>
                                            <li><a class=\"dropdown-item\" href=\"/views/tipos-actos.php\">Tipos de actos</a></li>
                                        </ul>
                                    </li>");
                        }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/views/calendario.php">Calendario de actos</a>
                    </li>
                </ul>
            </div>

            <div class="dropdown text-end">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $user->getNombre() . ' ' . $user->getApellido1() . ' ' . $user->getApellido2() ?>
                </a>
                <ul class="dropdown-menu text-small">
                    <li class="d-flex align-items-center"><i class="fa fa-user fa-1" style="margin-left: 10px;"></i>&nbsp;<a class="dropdown-item" href="/views/profile.php?id=<?php echo $user->getId_persona(); ?>"style="padding-left: 5px !important;">Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="d-flex align-items-center"><i class="fa fa-sign-out fa-1" style="margin-left: 10px;"></i>&nbsp;<a class="dropdown-item" href="/php/logout.php" style="padding-left: 5px !important;">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>