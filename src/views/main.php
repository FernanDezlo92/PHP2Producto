<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/initUser.php';
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Gestor de eventos DevBackend</title>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/includes.php' ?>
    </head>

    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/header.php' ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/svg.php' ?>

        <div class="container px-3 py-5" id="icon-grid">
            <h1 class="pb-2 border-bottom" style="text-align: left;">Menú principal de <b><?= $tipoUsuario->getDescripcion() ?></b></h1>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-3 py-5" style="text-align: justify !important;";>
                <?php 
                    if ($tipoUsuario->getId_tipo_usuario() == 1) {
                        echo  ("<div class=\"col d-flex align-items-start tarjeta-menu\" onclick=\"window.location.href='/views/actos.php'\">
                                    <svg class=\"bi text-muted flex-shrink-0 me-3\" width=\"1.75em\" height=\"1.75em\"><use xlink:href=\"#calendar-plus\"/></svg>
                                    <div>
                                        <h4 class=\"fw-bold mb-0\">Gestión de actos</h4>
                                        <p>Pantalla de administración para la gestión de actos: altas, modificaciones y altas. Gestión de personas inscritas en los actos.</p>
                                    </div>
                                </div>
                                <div class=\"col d-flex align-items-start tarjeta-menu\" onclick=\"window.location.href='/views/usuarios.php'\">
                                    <svg class=\"bi text-muted flex-shrink-0 me-3\" width=\"1.75em\" height=\"1.75em\"><use xlink:href=\"#person-gear\"/></svg>
                                    <div>
                                        <h4 class=\"fw-bold mb-0\">Gestión de usuarios</h4>
                                        <p>Creación, modificación y eliminación de nuevos usuarios que pueden acceder a la aplicación Gestión de sus tipologías de usuario.</p>
                                    </div>
                                </div>
                                <div class=\"col d-flex align-items-start tarjeta-menu\" onclick=\"window.location.href='/views/tiposActos.php'\">
                                    <svg class=\"bi text-muted flex-shrink-0 me-3\" width=\"1.75em\" height=\"1.75em\"><use xlink:href=\"#db-gear\"/></svg>
                                    <div>
                                        <h4 class=\"fw-bold mb-0\">Gestión de tipos de actos</h4>
                                        <p>Pantalla de administración para la gestión de las tipologías de actos disponibles en la aplicación.</p>
                                    </div>
                                </div>");
                    }
                ?>
                <div class="col d-flex align-items-start tarjeta-menu" onclick="window.location.href='/views/calendario.php'">
                    <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#calendar3"/></svg>
                    <div>
                        <h4 class="fw-bold mb-0">Calendario de actos</h4>
                        <p>Buscador de actos disponibles para la inscripción como asistente.</p>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>