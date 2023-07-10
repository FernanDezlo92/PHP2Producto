<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Acto.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/ActoCo.php';

    $acto = new ActoCo($conn);
    $actos = $acto->getAll();
?>

<div class="px-3 py-5" style="width: 100%; display: flex; justify-content: center; align-items: center;">
    <table class="table" style="width: 70%;">
        <thead>
            <tr>
                <td align="left" colspan="8"><h1 class="pb-2 border-bottom" style="text-align: left;">Gestión de actos</h1></td>
                <td><a href="/views/admin/actosNuevo.php"><button class="btn btn-success"><i class="fa fa-plus fa-lg"></i>&nbsp;Crear acto</button></a></td>
            </tr>
        </thead>
        <thead style="background-color: #E9ECEF;">
            <tr>
                <th scope="col" width="60px">#</th>
                <th scope="col" width="110px">Fecha</th>
                <th scope="col" width="80px">Hora</th>
                <th scope="col" width="190px" style="text-align: left;">Tipo</th>
                <th scope="col" width="200px" style="text-align: left;">Titulo</th>
                <th scope="col" width="320px" style="text-align: left;">Descripción</th>
                <th scope="col" width="110px">Nº asistentes</th>
                <th scope="col" width="110px">Nº inscritos</th>
                <th scope="col" width="*">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="9" style="padding: 0px !important;">
                    <div class="div-listado" style="width: 100%;">
                        <table class="table table-hover" style="width: 100%;">
                            <tbody>
                                <?php
                                    if (count($actos) > 0) {
                                        foreach ($actos as $reg) {
                                            echo "<tr style=\"padding: 0px; margin: 0px;\">
                                                    <td width=\"60px\">". $reg["Id_acto"] . "</th>
                                                    <td width=\"110px\">". date('d/m/Y', strtotime($reg['Fecha'])) . "</td>
                                                    <td width=\"80px\">". $reg['Hora'] . "</td>
                                                    <td width=\"190px\" align='left'>". $reg['Tipo_acto'] . "</td>
                                                    <td width=\"200px\" align='left'>". $reg['Titulo'] . "</td>
                                                    <td width=\"320px\" align='left'>". $reg['Descripcion_corta'] . "</td>
                                                    <td width=\"110px\">". $reg['Num_asistentes'] . "</td>
                                                    <td width=\"110px\">". $reg['Num_inscritos'] . "</td>
                                                    <td width=\"*\">
                                                        <button class=\"btn btn-primary\" onclick='editarActo(" . $reg["Id_acto"] . ")'><i class=\"fa fa-edit fa-lg\"></i></button>
                                                        <button class=\"btn btn-danger\" onclick='eliminarActo(" . $reg["Id_acto"] . ")'><i class=\"fa fa-trash-o fa-lg\"></i></button>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr>
                                                <td colspan='9'>No existen actos creados</td>
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

<div class="modal fade" id="modalActoDelete" tabindex="1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar acto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro que quieres borrar este acto y todos sus participantes y ponentes asociados?</p>
                <form action="/php/actosFormAccion.php" method="POST">
                    <input type="hidden" id="Id_acto" name="Id_acto" value=""/>
                    <button type="button" class="btn btn-primary" id="cancelDelete">Cancelar</button>
                    <button type="submit" class="btn btn-danger" id="deleteActo" name ="delete">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editarActo(id) {
        var url = "/views/admin/actosEditar.php?id=" + id;
        window.location.href = url;
    }

    function eliminarActo(id) {
        document.getElementById('Id_acto').value = id;
        const modal = new bootstrap.Modal(document.getElementById('modalActoDelete'), {
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
        if ($estadoAccion == 'ok') {
            $class = 'text-bg-success';
            $mensaje = 'Acto eliminado correctamente';
        } else if ($estadoAccion == 'ko') {
            $class = 'text-bg-danger';
            $mensaje = 'Error en la eliminación del acto';
        }
        echo '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast '.$class.'" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header">
                        <i class="fa '.($estadoAccion == 'ok' ? 'fa-check-circle' : 'fa-times-circle').'" aria-hidden="true"></i>&nbsp;<strong class="me-auto">'.$mensaje.'</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        '.($estadoAccion == 'ok' ? 'Acto eliminado correctamente de la base de datos.' : 'El acto no se ha podido eliminar de la base de datos.').'
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
