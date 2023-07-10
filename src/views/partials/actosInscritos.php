<?php
    $usuariosInscritos = $actoCo->getInscritosEnActo($_GET['id']);
?>
<div class="tab-pane" id="inscritos" role="tabpanel" aria-labelledby="inscritos-tab">
    <form action="/php/actosFormAccion.php" method="POST" style="width: 450px;">
        <div class="form-group" style="max-height: 555px;">
            <label class="form-label">Inscripciones</label>
            <table class="mt-1 table" style="font-size: 14px;">
                <thead style="background-color: #E9ECEF;">
                    <tr>
                        <th scope="col" width="370px" style="text-align: left;">Nombre y apellidos</th>
                        <th scope="col" width="*">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" style="padding: 0px !important; border-bottom: 0px !important;">
                            <div class="div-listado" style="width: 100%; max-height: 475px !important;">
                                <table class="table table-hover" style="width: 100%;">
                                    <tbody>
                                        <?php
                                            if (count($usuariosInscritos) > 0) {
                                                foreach ($usuariosInscritos as $reg) {
                                                    echo "<tr style=\"padding: 0px; margin: 0px;\">
                                                            <td width=\"370px\" align='left'>". $reg['Nombre_completo'] . "</td>
                                                            <td width=\"*\">
                                                                <button type=\"button\" class=\"btn btn-danger\" onclick='eliminarInscrito(" . $reg["Id_persona"] . ");'><i class=\"fa fa-user-times fa-lg\"></i></button>
                                                            </td>
                                                        </tr>";
                                                }
                                            } else {
                                                echo "<tr>
                                                        <td colspan='2' style='text-align: center;'>No hay ningún usuario inscrito</td>
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
        <button type="button" class="btn btn-danger" onclick="volver()">Volver</button>
    </form>
</div>

<div class="modal fade" id="modalInscritoDelete" tabindex="1" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desinscribir usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro que quieres desinscribir del acto a este usuario?</p>
                <form action="/php/actosFormAccion.php" method="POST">
                    <input type="hidden" name="Id_acto" value="<?php echo $_GET['id']; ?>"/>
                    <input type="hidden" id="Id_persona_inscrita" name="Id_persona" value=""/>
                    <button type="button" class="btn btn-primary" id="cancelDeleteInscrito">Cancelar</button>
                    <button type="submit" class="btn btn-danger" id="deleteInscrito" name ="deleteInscrito">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function eliminarInscrito(id) {
        document.getElementById('Id_persona_inscrita').value = id;
        const modalInscrito = new bootstrap.Modal(document.getElementById('modalInscritoDelete'), {
            keyboard: false
        });
        const cancelarInscritoBtn = document.getElementById('cancelDeleteInscrito');
        cancelarInscritoBtn.addEventListener('click', () => {
            modalInscrito.hide();
        });
        modalInscrito.show();
    }
</script>

<?php
    $estadoAccionInscrito = $_SESSION['estadoAccionInscrito'] ?? null;
    if ($estadoAccionInscrito) {
        $class = '';
        $mensaje = '';
        if ($estadoAccionInscrito == 'ok') {
            $class = 'text-bg-success';
            $mensaje = 'Usuario desinscrito correctamente';
        } else if ($estadoAccionInscrito == 'ko') {
            $class = 'text-bg-danger';
            $mensaje = 'Error en la desinscripción del usuario';
        }
        echo '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast '.$class.'" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header">
                        <i class="fa '.($estadoAccionInscrito == 'ok' ? 'fa-check-circle' : 'fa-times-circle').'" aria-hidden="true"></i>&nbsp;<strong class="me-auto">'.$mensaje.'</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        '.($estadoAccionInscrito == 'ok' ? 'Inscripción eliminada correctamente de la base de datos.' : 'El usuario no se ha podido desinscribir del acto en la base de datos.').'
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
        unset($_SESSION['estadoAccionInscrito']);
    }
?>