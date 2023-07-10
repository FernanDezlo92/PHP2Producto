<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/initUser.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Persona.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/PersonaCo.php';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Gestor de eventos DevBackend - Perfil</title>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/includes.php' ?>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/header.php' ?>
        <div class="container px-3 py-5">
            <h1 class="pb-2 border-bottom" style="text-align: left;">Editando el perfil del usuario: <b><?php echo $user->getUser(); ?></b></h1>
            <div class="container" style="justify-content: center; align-items: center; width: 600px;">
                <div class="tab-content clearfix formulario-datos-completo" style="width: 576px;" id="PerfilContent">
                    <form action="/php/profileAccion.php" method="POST" style="width: 400px;">
                        <div class="form-profile">
                            <input type="hidden" id="Id_persona" name="Id_persona" value="<?php echo $user->getId_persona(); ?>"/>
                            <div class="form-floating">
                                <input type="text" class="form-control" name="Nombre" id="floatingNombre" placeholder="Nombre" value="<?php echo $user->getNombre(); ?>" required>
                                <label for="floatingUser">Nombre</label>
                            </div>
                            <div class="mt-3 form-floating">
                                <input type="text" class="form-control" name="Apellido1" id="floatingApellido1" placeholder="Primer apellido" value="<?php echo $user->getApellido1(); ?>" required>
                                <label for="floatingApellido1">Primer apellido</label>
                            </div>
                            <div class="mt-3 form-floating">
                                <input type="text" class="form-control" name="Apellido2" id="floatingApellido2" placeholder="Segundo apellido" value="<?php echo $user->getApellido2(); ?>" required>
                                <label for="floatingApellido2">Segundo apellido</label>
                            </div>
                            <div class="mt-3 form-floating">
                                <input type="email" class="form-control" name="Email" id="floatingEmail" placeholder="E-mail" value="<?php echo $user->getEmail(); ?>">
                                <label for="floatingUser">E-mail</label>
                            </div>
                            <div class="mt-3 form-floating">
                                <div class="form-check" style="padding-top: 5px; padding-bottom: 5px;">
                                    <input class="form-check-input" type="checkbox" id="Anonimo" name="Anonimo" <?php if($user->getAnonimo() == "1") echo ('checked'); ?>>
                                    <label class="form-check-label" for="Anonimo"><b>No quiero aparecer en el listado público de asistentes a actos</b></label>
                                </div>
                            </div>
                            <div class="mt-3 form-floating">
                                <input class="form-control" type="password" placeholder="Cambiar contraseña" id="Password" name="Password"/>
                                <label for="Contraseña">Cambiar contraseña</label>
                            </div>
                            <div class="mt-3 form-floating">
                                <input class="form-control" type="password" placeholder="Confirma la contraseña" id="Confirm_Password" name="Confirm_Password"/>
                                <label for="Confirm_Password">Confirma la contraseña</label>
                            </div>
                            <div class="mb-3">
                                <?php if (!empty($message)): ?>
                                    <?= $message ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" name="update">Actualizar datos</button>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>

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
    
    $validPass = $_SESSION['validPass'] ?? null;
    if ($validPass) {
        echo '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header">
                        <i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;<strong class="me-auto">Error en la actualización de la contraseña</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        Las contraseñas introducidas no coinciden.
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
        unset($_SESSION['validPass']);
    }
?>