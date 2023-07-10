<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/initUser.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Acto.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/ActoCo.php';
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Calendario de actos</title>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/includes.php' ?>
    </head>

    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/header.php' ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/calendarioLista.php'; ?>
    </body>
</html>


