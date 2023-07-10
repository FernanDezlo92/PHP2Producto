<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/initUser.php';
    $action = 'update';
    $actionText = 'Guardar';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Edición de usuario</title>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/includes.php' ?>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/header.php' ?>
        <div class="container px-3 py-5">
            <h1 class="pb-2 border-bottom" style="text-align: left;">Editar usuario</h1>
            <div class="container" style="justify-content: center; align-items: center; width: 600px;">
                <div style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
                    <ul class="nav nav-tabs" id="usuariosTab" style="width: 600px;" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="datos-tab" data-bs-toggle="tab" data-bs-target="#datos" type="button" role="tab" aria-controls="datos" aria-selected="true">Datos generales</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="actos-tab" data-bs-toggle="tab" data-bs-target="#actos" type="button" role="tab" aria-controls="actos" aria-selected="false">Actos inscritos</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content clearfix formulario-datos" style="width: 576px;" id="usuariosTabContent">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/usuariosForm.php' ?>
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/usuariosInscritos.php' ?>
                </div>
            </div>
        </div>

    </body>
</html>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/php/usuariosFormLlenar.php' ?>

