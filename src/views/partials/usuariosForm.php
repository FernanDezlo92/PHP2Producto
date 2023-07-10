<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Persona.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/TipoUsuario.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/PersonaCo.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/TipoUsuarioCo.php';
    $personaCo = new PersonaCo($conn);
    $tipoUsuarioCo = new TipoUsuarioCo($conn);
    $tiposUsuarios = $tipoUsuarioCo->getAll();
?>
<div class="tab-pane show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
    <form action="/php/usuariosFormAccion.php" method="POST" style="width: 450px;">
        <input type="hidden" id="Id_persona" name="Id_persona"/>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label class="form-label" for="Titulo">Usuario&nbsp;<span class="required" title="Campo requerido">*</span></label>
                    <input class="form-control" type="text" placeholder="Usuario" id="User" name="User" maxlength="20" required <?php if(!empty($_GET['id'])) echo 'readonly'; ?>/>
                </div>
                <div class="col">
                    <label class="form-label" for="Id_tipo_usuario">Tipo de usuario&nbsp;<span class="required" title="Campo requerido">*</span></label>
                    <select class="form-control" id="Id_tipo_usuario" name="Id_tipo_usuario" required>
                        <option value=""></option>
                        <?php
                            foreach ($tiposUsuarios as $reg) {
                                echo '<option value="' . $reg['Id_tipo_usuario'] . '">' . $reg['Descripcion'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="Titulo">Nombre&nbsp;<span class="required" title="Campo requerido">*</span></label>
            <input class="form-control" type="text" placeholder="Nombre" id="Nombre" name="Nombre" maxlength="50" required/>
        </div>
        <div class="form-group">
            <label class="form-label" for="Titulo">Primer apellido&nbsp;<span class="required" title="Campo requerido">*</span></label>
            <input class="form-control" type="text" placeholder="Primer apellido" id="Apellido1" name="Apellido1" maxlength="50" required/>
        </div>
        <div class="form-group">
            <label class="form-label" for="Titulo">Segundo apellido&nbsp;<span class="required" title="Campo requerido">*</span></label>
            <input class="form-control" type="text" placeholder="Segundo apellido" id="Apellido2" name="Apellido2" maxlength="50" required/>
        </div>
        <div class="form-group">
            <label class="form-label" for="Titulo">E-mail</label>
            <input class="form-control" type="email" placeholder="E-mail" id="Email" name="Email" maxlength="200"/>
        </div>
        <br>
        <button type="submit" class="btn btn-primary" name="<?php echo $action; ?>"><?php echo $actionText; ?></button>
        <button type="button" class="btn btn-danger" onclick="volver()">Volver</button>
    </form>
</div>

<?php
    $estadoAccion = $_SESSION['estadoAccion'] ?? null;
    if ($estadoAccion) {
        $class = '';
        $mensaje = '';
        if ($estadoAccion == 'ok') {
            $class = 'text-bg-success';
            $mensaje = 'Datos actualizados correctamente';
        } else if ($estadoAccion == 'ko') {
            $class = 'text-bg-danger';
            $mensaje = 'Error en la actualización de datos';
        }
        echo '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast '.$class.'" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header">
                        <i class="fa '.($estadoAccion == 'ok' ? 'fa-check-circle' : 'fa-times-circle').'" aria-hidden="true"></i>&nbsp;<strong class="me-auto">'.$mensaje.'</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        '.($estadoAccion == 'ok' ? 'Los datos se han actualizado correctamente en la base de datos.' : 'Los datos no se han podido actualizar en la base de datos.').'
                    </div>
                </div>
            </div>';
        echo '<script>
                var myToast = document.getElementById("liveToast");
                var bsToast = new bootstrap.Toast(myToast);
                bsToast.show();
                setTimeout(function() {
                    bsToast.hide();
                }, 5000);
                </script>';
        unset($_SESSION['estadoAccion']);
    }
?>

<script>
    function volver() {
        var url = "/views/usuarios.php";
        window.location.href = url;
    }
</script>
