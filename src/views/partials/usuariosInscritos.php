<?php
    $actosInscritos = $personaCo->getActosInscritos($_GET['id']);
?>
<div class="tab-pane" id="actos" role="tabpanel" aria-labelledby="actos-tab">
    <form action="/php/usuariosFormAccion.php" method="POST" style="width: 450px;">
        <div class="form-group">
            <label class="form-label">Inscripciones en actos</label>
            <table class="mt-1 table" style="font-size: 14px;">
                <thead style="background-color: #E9ECEF;">
                    <tr>
                        <th scope="col" width="100px" style="text-align: center;">Fecha</th>
                        <th scope="col" width="100px" style="text-align: center;">Hora</th>
                        <th scope="col" width="*" style="text-align: left;">Titulo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" style="padding: 0px !important; border-bottom: 0px !important;">
                            <div class="div-listado" style="width: 100%; max-height: 475px !important;">
                                <table class="table table-hover" style="width: 100%;">
                                    <tbody>
                                        <?php
                                            if (count($actosInscritos) > 0) {
                                                foreach ($actosInscritos as $reg) {
                                                    echo "<tr style=\"padding: 0px; margin: 0px;\" ". ($reg['Ponente'] == 1 ? 'class="actoPonente"' : '') . ">
                                                            <td width=\"100px\" align='center'>". date('d/m/Y', strtotime($reg['Fecha'])) . "</td>
                                                            <td width=\"100px\" align='center'>". $reg['Hora'] . "</td>
                                                            <td width=\"*\" align='left'>". $reg['Titulo'] . "</td>
                                                        </tr>";
                                                }
                                            } else {
                                                echo "<tr>
                                                        <td colspan='4' style='text-align: center;'>No hay ningún acto inscrito</td>
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
