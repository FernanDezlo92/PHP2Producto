<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/initUser.php';
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Administración de actos</title>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/includes.php' ?>
    </head>

    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/header.php' ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/tipos-actosLista.php'; ?>
    </body>

</html>