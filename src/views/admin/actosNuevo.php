<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/initUser.php';
    $action = 'insert';
    $actionText = 'Crear';
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Creación de acto</title>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/includes.php' ?>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/header.php' ?>
        <div class="container px-3 py-5">
            <h1 class="pb-2 border-bottom" style="text-align: left;">Nuevo acto</h1>
            <div class="container" style="justify-content: center; align-items: center; width: 600px;">
                <div style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
                    <ul class="nav nav-tabs" style="width: 600px;">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#tab-1">Datos generales</a>
                        </li>
                    </ul>
                </div>
                <div class="formulario-datos" style="width: 576px;">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/actosForm.php' ?>
                </div>
            </div>
        </div>
    </body>
</html>


