<?php
    $id_tipo_acto = $_GET['id'];
    $tipoActo = $tipoActoCo->getById($id_tipo_acto);

    if ($tipoActo) {
        $idTipoActo = $tipoActo->getId_tipo_acto();
        $descripcion = $tipoActo->getDescripcion();
    
        echo '<script>
                document.getElementById("Id_tipo_acto").value = "' . $idTipoActo . '";
                document.getElementById("Descripcion").value = "' . $descripcion . '";
              </script>';
      }
?>