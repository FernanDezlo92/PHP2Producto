<?php
    if(!empty($_POST['User']) && !empty($_POST['password'])):
        $records = $conn->prepare('SELECT Id_persona, User, password, Id_tipo_usuario FROM personas WHERE User=:User');
        $records->bindParam(':User', $_POST['User']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        $message = '';

        if(is_array($results) && count($results) > 0 && password_verify($_POST['password'], $results['password']) ) {
            $_SESSION['Id_persona'] = $results['Id_persona'];
            header("Location: /views/main.php");
        } else {
            $message = 'Verifique su usuario y contraseña';
        }
        
    endif;  
?>