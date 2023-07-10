<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/login.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Gestor de eventos DevBackend - Login</title>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/includes.php' ?>
        <link rel="stylesheet" href="/assets/css/login.css">
    </head>
    <body>
        <main class="form-signin">
            <form class="formLogin" action="login.php" method="post">
                <h1 class="mb-3">Login</h1>
                <div class="form-floating">
                    <input type="text" class="form-control" name="User" id="floatingInput" placeholder="Usuario">
                    <label for="floatingInput">Usuario</label>
                </div>
                <div class="mt-3 form-floating">
                    <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Contraseña">
                    <label for="floatingPassword">Contraseña</label>
                </div>

                <div class="mb-3" style="color: #FF0000;">
                    <?php if (!empty($message)): ?>
                        <?= $message ?>
                    <?php endif; ?>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Acceder</button>
                <p class="mt-3">¿No tienes usuario? Regístrate <a href="signup.php">aquí</a></p>
                <p class="mt-4 mb-3 text-muted"><span style="font-family: 'Shantell Sans';">DevBackend</span> &copy; 2023</p>
            </form>
        </main>
    </body>
</html>