<?php
    /* Configuración local */
    $host = "mysql";
    $username = "root";
    $password = "Login";
    $database = "Word";

    /* Configuración AWS */
    // $host = "localhost";
    // $username = "wordpress1";
    // $password = "DWD8Ds3l4dvXpjZH";
    // $database = "wordpress1";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4",
                        $username, 
                        $password, 
                        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Activar el modo de errores de PDO
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ));  // Modo de recuperación de datos predeterminado
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
?>
