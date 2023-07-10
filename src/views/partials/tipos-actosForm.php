<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/TipoActo.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/TipoActoCo.php';
    $tipoActoCo = new TipoActoCo($conn);
?>
<div class="tab-pane show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
    <form action="/php/tipos-actosFormAccion.php" method="POST" style="width: 450px;">
        <input type="hidden" id="Id_tipo_acto" name="Id_tipo_acto"/>
        <div class="form-group">
            <label class="form-label" for="Descripcion">Descripción&nbsp;<span class="required" title="Campo requerido">*</span></label>
            <input class="form-control" type="text" placeholder="Descripción" id="Descripcion" name="Descripcion" maxlength="100" required/>
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
        var url = "/views/tipos-actos.php";
        window.location.href = url;
    }
</script>
