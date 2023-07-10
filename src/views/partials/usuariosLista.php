<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Persona.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/PersonaCo.php';

    $personaCo = new PersonaCo($conn);
    $personas = $personaCo->getAll();
?>

<div class="px-3 py-5" style="width: 100%; display: flex; justify-content: center; align-items: center;">
    <table class="table" style="width: 70%;">
        <thead>
            <tr>
                <td align="left" colspan="6"><h1 class="pb-2 border-bottom" style="text-align: left;">Gestión de usuarios</h1></td>
                <td><a href="/views/admin/usuariosNuevo.php"><button class="btn btn-success"><i class="fa fa-plus fa-lg"></i>&nbsp;Crear usuario</button></a></td>
            </tr>
        </thead>
        <thead style="background-color: #E9ECEF;">
            <tr>
                <th scope="col" width="65px">#</th>
                <th scope="col" width="180px">Usuario</th>
                <th scope="col" width="335px">Nombre y apellidos</th>
                <th scope="col" width="200px">E-mail</th>
                <th scope="col" width="200px">Tipo de usuario</th>
                <th scope="col" width="100px">Anónimo</th>
                <th scope="col" width="*">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" style="padding: 0px !important;">
                    <div class="div-listado" style="width: 100%;">
                        <table class="table table-hover" style="width: 100%;">
                            <tbody>
                                <?php
                                    if (count($personas) > 0) {
                                        foreach ($personas as $reg) {
                                            echo "<tr style=\"padding: 0px; margin: 0px;\">
                                                    <td width=\"65px\">". $reg["Id_persona"] . "</th>
                                                    <td width=\"180px\"><b>". $reg['User'] . "</b></td>
                                                    <td width=\"335px\" align='left'>". $reg['Apellido1'] . " " . $reg['Apellido2'] . ", " . $reg['Nombre'] . "</td>
                                                    <td width=\"200px\" align='left'>". $reg['Email'] . "</td>
                                                    <td width=\"200px\" class=\"tipoUsuario". $reg['Id_tipo_usuario'] . "\">". $reg['Tipo_usuario'] . "</td>
                                                    <td width=\"100px\">". ($reg['Anonimo'] == 1 ? 'Sí' : 'No') . "</td>
                                                    <td width=\"*\">
                                                        <button class=\"btn btn-primary\" onclick='editarUsuario(" . $reg["Id_persona"] . ")'><i class=\"fa fa-edit fa-lg\"></i></button>
                                                        <button class=\"btn btn-danger\" onclick='eliminarUsuario(" . $reg["Id_persona"] . ")'><i class=\"fa fa-trash-o fa-lg\"></i></button>

                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr>
                                                <td colspan='7'>No existen usuarios creados</td>
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

<div class="modal fade" id="modalUsuarioDelete" tabindex="1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro que quieres borrar este usuario y todas sus asistencias y/o ponencias a actos asociados?</p>
                <form action="/php/usuariosFormAccion.php" method="POST">
                    <input type="hidden" id="Id_persona" name="Id_persona" value=""/>
                    <button type="button" class="btn btn-primary" id="cancelDelete">Cancelar</button>
                    <button type="submit" class="btn btn-danger" id="deleteUsuario" name ="delete">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editarUsuario(id) {
        var url = "/views/admin/usuariosEditar.php?id=" + id;
        window.location.href = url;
    }

    function eliminarUsuario(id) {
        document.getElementById('Id_persona').value = id;
        const modal = new bootstrap.Modal(document.getElementById('modalUsuarioDelete'), {
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
            $mensaje = 'Usuario eliminado correctamente';
            $texto = 'Usuario eliminado correctamente de la base de datos.';
        } else if (($estadoAccion == 'ko') || ($estadoAccion == 'eq')) {
            $class = 'text-bg-danger';
            $mensaje = 'Error en la eliminación del usuario';
            $texto = ($estadoAccion == 'ko') ? 'El usuario no se ha podido eliminar de la base de datos.' : 'No puedes eliminar tu propio usuario.';
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
