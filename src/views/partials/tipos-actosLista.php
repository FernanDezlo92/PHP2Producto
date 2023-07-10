<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/TipoActo.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/TipoActoCo.php';

    $tipoActoCo = new TipoActoCo($conn);
    $tiposActos = $tipoActoCo->getAll();
?>

<div class="px-3 py-5" style="width: 100%; display: flex; justify-content: center; align-items: center;">
    <table class="table" style="width: 70%;">
        <thead>
            <tr>
                <td align="left" colspan="2"><h1 class="pb-2 border-bottom" style="text-align: left;">Gestión de tipos de actos</h1></td>
                <td><a href="/views/admin/tipos-actosNuevo.php"><button class="btn btn-success"><i class="fa fa-plus fa-lg"></i>&nbsp;Crear tipo de acto</button></a></td>
            </tr>
        </thead>
        <thead style="background-color: #E9ECEF;">
            <tr>
                <th scope="col" width="65px" style="padding-left: 150px;">#</th>
                <th scope="col" width="*" style="padding-left: 45px;text-align: left;">Descripción</th>
                <th scope="col" width="240px" style="padding-right: 150px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" style="padding: 0px !important;">
                    <div class="div-listado" style="width: 100%;">
                        <table class="table table-hover" style="width: 100%;">
                            <tbody>
                                <?php
                                    if (count($tiposActos) > 0) {
                                        foreach ($tiposActos as $reg) {
                                            echo "<tr style=\"padding: 0px; margin: 0px;\">
                                                    <td width=\"65px\" style=\"padding-left: 150px;\">". $reg["Id_tipo_acto"] . "</th>
                                                    <td width=\"*\" align='left' style='padding-left: 45px;'>". $reg['Descripcion'] . "</td>
                                                    <td width=\"245px\" style=\"padding-right: 140px;\">
                                                        <button class=\"btn btn-primary\" onclick='editarTipoActo(" . $reg["Id_tipo_acto"] . ")'><i class=\"fa fa-edit fa-lg\"></i></button>
                                                        <button class=\"btn btn-danger\" onclick='eliminarTipoActo(" . $reg["Id_tipo_acto"] . ")'><i class=\"fa fa-trash-o fa-lg\"></i></button>

                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr>
                                                <td colspan='8'>No existen tipos de actos creados</td>
                                            </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalTipoActoDelete" tabindex="1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar tipo de acto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro que quieres borrar este tipo de acto?</p>
                <form action="/php/tipos-actosFormAccion.php" method="POST">
                    <input type="hidden" id="Id_tipo_acto" name="Id_tipo_acto" value=""/>
                    <button type="button" class="btn btn-primary" id="cancelDelete">Cancelar</button>
                    <button type="submit" class="btn btn-danger" id="deleteTipoActo" name ="delete">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editarTipoActo(id) {
        var url = "/views/admin/tipos-actosEditar.php?id=" + id;
        window.location.href = url;
    }

    function eliminarTipoActo(id) {
        document.getElementById('Id_tipo_acto').value = id;
        const modal = new bootstrap.Modal(document.getElementById('modalTipoActoDelete'), {
            keyboard: false
        });
        const cancelarBtn = document.getElementById('cancelDelete');
        cancelarBtn.addEventListener('click', () => {
            modal.hide();
        });
        modal.show();
    }
</script>

<?php
    $estadoAccion = $_SESSION['estadoAccion'] ?? null;
    if ($estadoAccion) {
        $class = '';
        $mensaje = '';
        $texto = '';
        if ($estadoAccion == 'ok') {
            $class = 'text-bg-success';
            $mensaje = 'Tipo de acto eliminado correctamente';
            $texto = 'Tipo de acto eliminado correctamente de la base de datos.';
        } else if (($estadoAccion == 'ko') || ($estadoAccion == 'ex')) {
            $class = 'text-bg-danger';
            $mensaje = 'Error en la eliminación del tipo de acto';
            $texto = ($estadoAccion == 'ko') ? 'El tipo de acto no se ha podido eliminar de la base de datos.' : 'No puedes eliminar un tipo de acto relacionado con actos creados.';
        }
        echo '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast '.$class.'" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header">
                        <i class="fa '.($estadoAccion == 'ok' ? 'fa-check-circle' : 'fa-times-circle').'" aria-hidden="true"></i>&nbsp;<strong class="me-auto">'.$mensaje.'</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">' . $texto . '</div>
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
