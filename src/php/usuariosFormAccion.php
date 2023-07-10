<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/PersonaCo.php';

    if (isset($_POST['insert']) || isset($_POST['update'])) {
        $id = $_POST['Id_persona'] ?? null;
        $user = $_POST['User'] ?? null;
        $nombre = $_POST['Nombre'] ?? null;
        $apellido1 = $_POST['Apellido1'] ?? null;
        $apellido2 = $_POST['Apellido2'] ?? null;
        $email = $_POST['Email'] ?? null;
        $id_tipo_usuario = $_POST['Id_tipo_usuario'] ?? null;
    
        $personaCo = new PersonaCo($conn);
        
        if (isset($_POST['insert'])) {
            $personaCo->insert($nombre, $apellido1, $apellido2, $user, $email, $id_tipo_usuario);
        } else if (isset($_POST['update'])) {
            $password = null;
            $anonimo = null;
            $personaCo->update($id, $nombre, $apellido1, $apellido2, $email, $password, $id_tipo_usuario, $anonimo);
        }
    }

    if(isset($_POST['delete'])) {
        $id = $_POST['Id_persona'];
        if (($_SESSION['Id_persona'] == $id)) {
            $_SESSION['estadoAccion'] = 'eq';
            header("Location: /views/usuarios.php");
        } else {
            $personaCo = new PersonaCo($conn);
            $personaCo->delete($id);
        }
    }
?>