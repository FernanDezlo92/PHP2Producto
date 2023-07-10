<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/TipoActoCo.php';

    if (isset($_POST['insert']) || isset($_POST['update'])) {
        $id = $_POST['Id_tipo_acto'] ?? null;
        $descripcion = $_POST['Descripcion'] ?? null;
    
        $tipoActoCo = new TipoActoCo($conn);
        
        if (isset($_POST['insert'])) {
            $tipoActoCo->insert($descripcion);
        } else if (isset($_POST['update'])) {
            $tipoActoCo->update($id, $descripcion);
        }
    }

    if(isset($_POST['delete'])) {
        $id = $_POST['Id_tipo_acto'];
        $tipoActoCo = new TipoActoCo($conn);
        $actos = $tipoActoCo->getActosByTipo($id);
        if ((count($actos) > 0)) {
            $_SESSION['estadoAccion'] = 'ex';
            header("Location: /views/tipos-actos.php");
        } else {
            $tipoActoCo = new TipoActoCo($conn);
            $tipoActoCo->delete($id);
        }
    }
?>