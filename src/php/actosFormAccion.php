<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/ActoCo.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/PersonaActoCo.php';

    if (isset($_POST['insert']) || isset($_POST['update'])) {
        $id = $_POST['Id_acto'] ?? null;
        $fecha = $_POST['Fecha'] ?? null;
        $hora = $_POST['Hora'] ?? null;
        $titulo = $_POST['Titulo'] ?? null;
        $descripcion_c = $_POST['Descripcion_corta'] ?? null;
        $descripcion_l = $_POST['Descripcion_larga'] ?? null;
        $asistentes = $_POST['Num_asistentes'] ?? null;
        $Id_tipo_acto = $_POST['Id_tipo_acto'] ?? null;
    
        $actoCo = new ActoCo($conn);
        
        if (isset($_POST['insert'])) {
            $actoCo->insert($fecha, $hora, $titulo, $descripcion_c, $descripcion_l, $asistentes, $Id_tipo_acto);
        } else if (isset($_POST['update'])) {
            $actoCo->update($id, $fecha, $hora, $titulo, $descripcion_c, $descripcion_l, $asistentes, $Id_tipo_acto);
        }
    }

    if(isset($_POST['delete'])) {
        $id = $_POST['Id_acto'];
        $actoCo = new ActoCo($conn);
        $actoCo->delete($id);
    }

    if(isset($_POST['ponentes'])) {
        $id = $_POST['Id_acto'];
        $id_ponentes = $_POST['Ponentes'];
        $personaActoCo = new PersonaActoCo($conn);
        $personaActoCo->updatePonentesActo($id, $id_ponentes);
    }

    if(isset($_POST['deleteInscrito'])) {
        $id_acto = $_POST['Id_acto'];
        $id_persona = $_POST['Id_persona'];
        $personaActoCo = new PersonaActoCo($conn);
        $personaActoCo->deleteInscrito($id_acto, $id_persona);
    }
?>