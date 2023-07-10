<?php
    $id_persona = $_GET['id'];
    $persona = $personaCo->getById($id_persona);

    if ($persona) {
        $idPersona = $persona->getId_persona();
        $user = $persona->getUser();
        $nombre = $persona->getNombre();
        $apellido1 = $persona->getApellido1();
        $apellido2 = $persona->getApellido2();
        $email = $persona->getEmail();
        $id_tipo_usuario = $persona->getId_tipo_usuario();
    
        echo '<script>
                document.getElementById("Id_persona").value = "' . $idPersona . '";
                document.getElementById("User").value = "' . $user . '";
                document.getElementById("Nombre").value = "' . $nombre . '";
                document.getElementById("Apellido1").value = "' . $apellido1 . '";
                document.getElementById("Apellido2").value = "' . $apellido2 . '";
                document.getElementById("Email").value = "' . $email . '";
                document.getElementById("Id_tipo_usuario").value = "' . $id_tipo_usuario . '";
              </script>';
      }
?>