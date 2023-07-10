<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/PersonaCo.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/TipoUsuarioCo.php';
    $id_persona = $_SESSION['Id_persona'];
    $userCo = new PersonaCo($conn);
    $user = $userCo->getById($id_persona);
    $tipoUsuarioCo = new TipoUsuarioCo($conn);
    $tipoUsuario = $tipoUsuarioCo->getById($user->getId_tipo_usuario());
?>