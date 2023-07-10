<?php
    $message = '';
    if (!empty($_POST['password'])) {
        if ($_POST['confirm_password'] == $_POST['password']) {
            $test = "SELECT COUNT(*) total FROM personas WHERE User = :User";
            $stm1 = $conn->prepare($test);
            $stm1->bindParam(':User', $_POST['User']);
            $stm1->execute();
            $row = $stm1->fetch(PDO::FETCH_ASSOC);
            if ($row['total'] == '0') {
                $sql = "INSERT INTO personas (User, Nombre, Apellido1, Apellido2, password) VALUES (:User, :Nombre, :Apellido1, :Apellido2, :password)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':User', $_POST['User']);
                $stmt->bindParam(':Nombre', $_POST['Nombre']);
                $stmt->bindParam(':Apellido1', $_POST['Apellido1']);
                $stmt->bindParam(':Apellido2', $_POST['Apellido2']);
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $password);
                if ($stmt->execute()) {
                    $message = '<span style="color: #79bf73;">Usuario creado correctamente</span>';
                } else {
                    $message = '<span style="color: #FF0000;">Error al crear el usuario</span>';
                }
            } else {
                $message = '<span style="color: #FF0000;">Error al crear el usuario. El nombre de usuario introducido no está disponible</span>';
            }
        } else {
            $message = '<span style="color: #FF0000;">Las contraseñas no coinciden</span>';
        }
    }
?>