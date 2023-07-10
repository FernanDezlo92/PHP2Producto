<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/TipoUsuario.php';

    class TipoUsuarioCo {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function getAll() {
            $stmt = $this->conn->prepare("SELECT Id_tipo_usuario, Descripcion FROM tipos_usuarios ORDER BY Descripcion");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getById($Id_tipo_usuario) {
            try {
                $stmt = $this->conn->prepare("SELECT Id_tipo_usuario, Descripcion FROM tipos_usuarios WHERE Id_tipo_usuario = :Id_tipo_usuario");
                $stmt->bindParam(':Id_tipo_usuario', $Id_tipo_usuario);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    return new TipoUsuario($row['Id_tipo_usuario'], $row['Descripcion']);
                } else {
                    return null;
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
?>
