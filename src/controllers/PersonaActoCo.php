<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/PersonaActo.php';
    
    class PersonaActoCo {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function updatePonentesActo($id_acto, $Ponentes) {
            try {
                $stmt1 = $this->conn->prepare("DELETE FROM personas_actos WHERE Id_acto = :id_acto AND Ponente = 1");
                $stmt1->bindParam(':id_acto', $id_acto);
                $stmt1->execute();

                foreach ($Ponentes as $reg) {
                    $stmt = $this->conn->prepare("INSERT INTO personas_actos (Id_persona, Id_acto, Ponente) VALUES (:reg, :id_acto, 1)");
                    $stmt->bindParam(':reg', $reg);
                    $stmt->bindParam(':id_acto', $id_acto);
                    $stmt->execute();
                }

                $_SESSION['estadoAccion'] = 'ok';
                header("Location: /views/admin/actosEditar.php?id=" . $id_acto);
            } catch(PDOException $e) {
                $_SESSION['estadoAccion'] = 'ko';
                header("Location: /views/admin/actosEditar.php?id=" . $id_acto);
            }
        }

        public function deleteInscrito($id_acto, $id_persona) {
            try {
                $stmt = $this->conn->prepare("DELETE FROM personas_actos WHERE Id_acto = :id_acto AND Id_persona = :id_persona");
                $stmt->bindParam(':id_acto', $id_acto);
                $stmt->bindParam(':id_persona', $id_persona);
                $stmt->execute();
                $_SESSION['estadoAccionInscrito'] = 'ok';
                header("Location: /views/admin/actosEditar.php?id=" . $id_acto);
            } catch(PDOException $e) {
                $_SESSION['estadoAccionInscrito'] = 'ko';
                header("Location: /views/admin/actosEditar.php?id=" . $id_acto);
            }
        }

        public function inscribirActo($id_acto, $id_persona) {
            try {
                $stmt = $this->conn->prepare("INSERT INTO personas_actos (Id_acto, Id_persona, Ponente) VALUES (:id_acto, :id_persona, 0)");
                $stmt->bindParam(':id_acto', $id_acto);
                $stmt->bindParam(':id_persona', $id_persona);
                $stmt->execute();
                $_SESSION['estadoAccion'] = 'ok';
                $_SESSION['tipoAccion'] = 'A';
            } catch(PDOException $e) {
                $_SESSION['estadoAccionInscrito'] = 'ko';
                $_SESSION['tipoAccion'] = 'A';
            }
        }

        public function desinscribirActo($id_acto, $id_persona) {
            try {
                $stmt = $this->conn->prepare("DELETE FROM personas_actos WHERE Id_acto = :id_acto AND Id_persona = :id_persona");
                $stmt->bindParam(':id_acto', $id_acto);
                $stmt->bindParam(':id_persona', $id_persona);
                $stmt->execute();
                $_SESSION['estadoAccion'] = 'ok';
                $_SESSION['tipoAccion'] = 'B';
            } catch(PDOException $e) {
                $_SESSION['estadoAccionInscrito'] = 'ko';
                $_SESSION['tipoAccion'] = 'B';
            }
        }
    }
?>
