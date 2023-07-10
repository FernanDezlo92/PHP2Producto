<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/TipoActo.php';

    class TipoActoCo {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function getAll() {
            $stmt = $this->conn->prepare("SELECT Id_tipo_acto, Descripcion FROM tipo_acto ORDER BY Descripcion");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getById($id_tipo_acto) {
            try {
                $stmt = $this->conn->prepare("SELECT Id_tipo_acto, Descripcion FROM tipo_acto WHERE Id_tipo_acto = :id_tipo_acto");
                $stmt->bindParam(':id_tipo_acto', $id_tipo_acto);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    return new TipoActo($row['Id_tipo_acto'], $row['Descripcion']);
                } else {
                    return null;
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        public function getActosCreados($id_tipo_acto) {
            $stmt = $this->conn->prepare("SELECT ac.Id_acto, ac.Fecha, TIME_FORMAT(ac.Hora, '%H:%i') Hora, ac.Titulo
                                            FROM actos ac JOIN tipo_acto ta ON ac.Id_tipo_acto = ta.Id_tipo_acto
                                           WHERE ta.Id_tipo_acto = :id_tipo_acto 
                                        ORDER BY ac.Fecha DESC, ac.Hora DESC;");
            $stmt->bindParam(':id_tipo_acto', $id_tipo_acto);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function insert($descripcion) {
            try {
                $stmt = $this->conn->prepare("INSERT INTO tipo_acto (Descripcion) 
                VALUES (:descripcion)");

                $stmt->bindParam(':descripcion', $descripcion);

                $stmt->execute();
                $id_insertado = $this->conn->lastInsertId();
                $_SESSION['estadoAccion'] = 'ok';
                header("Location: /views/admin/tipos-actosEditar.php?id=" . $id_insertado);
            } catch(PDOException $e) {
                $_SESSION['estadoAccion'] = 'ko';
                header("Location: /views/admin/tipos-actosEditar.php?id=" . $id_acto);
            }
        }

        public function update($id_tipo_acto, $descripcion) {
            try {
                $stmt = $this->conn->prepare("UPDATE tipo_acto SET Descripcion = :descripcion WHERE Id_tipo_acto = :id_tipo_acto");

                $stmt->bindParam(':id_tipo_acto', $id_tipo_acto);
                $stmt->bindParam(':descripcion', $descripcion);

                $stmt->execute();
                $_SESSION['estadoAccion'] = 'ok';
                header("Location: /views/admin/tipos-actosEditar.php?id=" . $id_tipo_acto);
            } catch(PDOException $e) {
                $_SESSION['estadoAccion'] = 'ko';
                header("Location: /views/admin/tipos-Editar.php?id=" . $id_tipo_acto);
            }
        }

        public function delete($id_tipo_acto) {
            try {
                $stmt = $this->conn->prepare("DELETE FROM tipo_acto WHERE Id_tipo_acto = :id_tipo_acto");
                $stmt->bindParam(':id_tipo_acto', $id_tipo_acto);
                $stmt->execute();
                $_SESSION['estadoAccion'] = 'ok';
                header("Location: /views/tipos-actos.php");
            } catch(PDOException $e) {
                $_SESSION['estadoAccion'] = 'ko';
                header("Location: /views/tipos-actos.php");
            }
        }

        public function getActosByTipo($id_tipo_acto) {
            try {
                $stmt = $this->conn->prepare("SELECT Id_acto, Fecha, TIME_FORMAT(Hora, '%H:%i') Hora, Titulo, Descripcion_corta, Descripcion_larga, Num_asistentes, Id_tipo_acto FROM actos WHERE Id_tipo_acto = :id_tipo_acto ORDER BY Fecha DESC, Hora DESC");
                $stmt->bindParam(':id_tipo_acto', $id_tipo_acto);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
?>
