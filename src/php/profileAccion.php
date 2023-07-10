<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/PersonaCo.php';

    if (isset($_POST['update'])) {
        $valid = false;
        $id_tipo_usuario = "";
        if (!empty($_POST['Password'])) {
            if ($_POST['Confirm_Password'] == $_POST['Password']) {
                $valid = true;
                $password = password_hash($_POST['Password'], PASSWORD_BCRYPT);
            }
        } else {
            $valid = true;
            $password = "";
        }
        
        if ($valid) {
            $personaCo = new PersonaCo($conn);
            $id_persona = $_POST['Id_persona'] ?? null;
            $nombre = $_POST['Nombre'] ?? null;
            $apellido1 = $_POST['Apellido1'] ?? null;
            $apellido2 = $_POST['Apellido2'] ?? null;
            $email = $_POST['Email'] ?? null;
            $anonimo = isset($_POST['Anonimo']) ? "1" : "0";
            $personaCo->update($id_persona, $nombre, $apellido1, $apellido2, $email, $password, $id_tipo_usuario, $anonimo);
        } else {
            $_SESSION['validPass'] = 'NO';
            header("Location: /views/profile.php?id=" . $_POST['Id_persona']);
        }
    }

    if(!empty($_POST['user']) && !empty($_POST['password'])) {
        $message = '';
        $id_persona = $_POST['id'];
        $records = $conn->prepare('UPDATE personas SET User=:User, password=:password, Email=:email WHERE Id_persona=:id');
        $records->bindParam(':User', $_POST['user']);
        $records->bindParam(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));
        $records->bindParam(':email', $_POST['email']);
        $records->bindParam(':id', $id_persona, PDO::PARAM_INT);
        $records->execute();

        // Verificar si se actualizaron filas
        if ($records->rowCount() > 0) {
            $message = 'Datos actualizados correctamente';
        } else {
            $message = 'No se pudo actualizar la información';
        }
        echo $message;
    }

?>
