<?php
    $usuariosPonentes = $personaCo->getPonentesEnActo($_GET['id']);
?>
<div class="tab-pane" id="ponentes" role="tabpanel" aria-labelledby="ponentes-tab">
    <form action="/php/actosFormAccion.php" method="POST" style="width: 450px;">
        <input type="hidden" id="Id_acto" name="Id_acto" value="<?php echo $_GET['id'] ?>"/>
        <div class="form-group">
            <label class="form-label" for="Ponentes">Ponentes&nbsp;<span class="required" title="Campo requerido">*</span></label>
            <select class="form-control" id="Ponentes" name="Ponentes[]" required multiple size="24">
                <?php
                    foreach ($usuariosPonentes as $reg) {
                        $selected = $reg['En_acto'] == 1 ? "selected" : "";
                        echo '<option value="' . $reg['Id_persona'] . '" ' . $selected . '>' . $reg['Nombre_completo'] . '</option>';
                    }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="ponentes">Guardar</button>
        <button type="button" class="btn btn-danger" onclick="volver()">Volver</button>
    </form>
</div>
