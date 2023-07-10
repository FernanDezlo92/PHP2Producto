<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/PersonaActoCo.php';

    $id_acto = $_GET['id_acto'];
    $id_persona = $_GET['id_persona'];
    $accion = $_GET['accion'];
    $personaActoCo = new PersonaActoCo($conn);
    if ($accion == "A") {
        $personaActoCo->inscribirActo($id_acto, $id_persona);
    } else {
        $personaActoCo->desinscribirActo($id_acto, $id_persona);
    }
?>