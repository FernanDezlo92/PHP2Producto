<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Persona.php';
    
    class PersonaCo {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function getAll() {
            $stmt = $this->conn->prepare("SELECT pe.Id_persona, pe.Nombre, pe.Apellido1, pe.Apellido2, pe.User, pe.Email, pe.Password, pe.Id_tipo_usuario, tu.Descripcion Tipo_usuario, pe.Anonimo FROM personas pe JOIN tipos_usuarios tu ON tu.Id_tipo_usuario = pe.Id_tipo_usuario ORDER BY Apellido1, Apellido2, Nombre, User");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getById($id_persona) {
            try {
                $stmt = $this->conn->prepare("SELECT Id_persona, Nombre, Apellido1, Apellido2, User, Email, Password, Id_tipo_usuario , Anonimo FROM personas WHERE Id_persona = :id_persona");
                $stmt->bindParam(':id_persona', $id_persona);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    return new Persona($row['Id_persona'], $row['Nombre'], $row['Apellido1'], $row['Apellido2'], $row['User'], $row['Email'], $row['Password'], $row['Id_tipo_usuario'], $row['Anonimo']);
                } else {
                    return null;
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        public function getByTipo($Id_tipo) {
            $stmt = $this->conn->prepare("SELECT Id_persona, CONCAT(CONCAT_WS(' ', Apellido1, Apellido2), CONCAT(', ', Nombre)) AS Nombre_completo FROM personas WHERE Id_tipo_usuario = :id_tipo");
            $stmt->bindParam(':id_tipo', $Id_tipo);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getPonentesEnActo($id_acto) {
            $stmt = $this->conn->prepare("SELECT pe.Id_persona, CONCAT(CONCAT_WS(' ', pe.Apellido1, pe.Apellido2), CONCAT(', ', pe.Nombre)) AS Nombre_completo, 
                                                 (SELECT COUNT(*) FROM personas_actos pa WHERE pa.Id_persona = pe.Id_persona AND pa.Id_acto = :id_acto AND pa.Ponente = 1) En_acto 
                                            FROM personas pe 
                                           WHERE pe.Id_tipo_usuario = 3 
                                             AND pe.Id_persona NOT IN (SELECT px.Id_persona FROM personas_actos px WHERE px.Id_acto = :id_acto AND px.Ponente = 0) 
                                        ORDER BY 2;");
            $stmt->bindParam(':id_acto', $id_acto);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getActosInscritos($id_persona) {
            $stmt = $this->conn->prepare("SELECT ac.Id_acto, ac.Fecha, TIME_FORMAT(ac.Hora, '%H:%i') Hora, ac.Titulo, pa.Ponente
                                            FROM actos ac JOIN personas_actos pa ON ac.Id_acto = pa.Id_acto
                                           WHERE pa.Id_persona = :id_persona 
                                        ORDER BY ac.Fecha DESC, ac.Hora DESC;");
            $stmt->bindParam(':id_persona', $id_persona);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function insert($nombre, $apellido1, $apellido2, $user, $email, $id_tipo_usuario) {
            try {
                $password = password_hash('a', PASSWORD_BCRYPT);
                $anonimo = '0';
                $stmt = $this->conn->prepare("INSERT INTO personas (Nombre, Apellido1, Apellido2, User, Email, Password, Id_tipo_usuario, Anonimo) 
                VALUES (:nombre, :apellido1, :apellido2, :user, :email, :password, :id_tipo_usuario, :anonimo)");

                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':apellido1', $apellido1);
                $stmt->bindParam(':apellido2', $apellido2);
                $stmt->bindParam(':user', $user);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':id_tipo_usuario', $id_tipo_usuario);
                $stmt->bindParam(':anonimo', $anonimo);

                $stmt->execute();
                $id_insertado = $this->conn->lastInsertId();
                $_SESSION['estadoAccion'] = 'ok';
                header("Location: /views/admin/usuariosEditar.php?id=" . $id_insertado);
            } catch(PDOException $e) {
                $_SESSION['estadoAccion'] = 'ko';
                echo "Error: " . $e->getMessage();
                // header("Location: /views/admin/usuariosNuevo.php");
            }
        }

        public function update($id_persona, $nombre, $apellido1, $apellido2, $email, $password, $id_tipo_usuario, $anonimo) {
            try {
                $stmt = $this->conn->prepare("UPDATE personas SET Nombre = :nombre, Apellido1 = :apellido1, Apellido2 = :apellido2, Email = :email WHERE Id_persona = :id_persona");
                $stmt->bindParam(':id_persona', $id_persona);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':apellido1', $apellido1);
                $stmt->bindParam(':apellido2', $apellido2);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                if (!empty($password)) {
                    $stm2 = $this->conn->prepare("UPDATE personas SET Password = :password WHERE Id_persona = :id_persona");
                    $stm2->bindParam(':id_persona', $id_persona);
                    $stm2->bindParam(':password', $password);
                    $stm2->execute();
                }

                if (($anonimo == '1') || ($anonimo == '0')) {
                    $stm3 = $this->conn->prepare("UPDATE personas SET Anonimo = :anonimo WHERE Id_persona = :id_persona");
                    $stm3->bindParam(':id_persona', $id_persona);
                    $stm3->bindParam(':anonimo', $anonimo);
                    $stm3->execute();
                }

                if (!empty($id_tipo_usuario)) {
                    $stm4 = $this->conn->prepare("UPDATE personas SET Id_tipo_usuario = :id_tipo_usuario WHERE Id_persona = :id_persona");
                    $stm4->bindParam(':id_persona', $id_persona);
                    $stm4->bindParam(':id_tipo_usuario', $id_tipo_usuario);
                    $stm4->execute();
                }

                $_SESSION['estadoAccion'] = 'ok';
                if (!empty($id_tipo_usuario)) {
                    header("Location: /views/admin/usuariosEditar.php?id=" . $id_persona);
                } else {
                    header("Location: /views/profile.php?id=" . $id_persona);
                }
            } catch(PDOException $e) {
                $_SESSION['estadoAccion'] = 'ko';
                if (!empty($id_tipo_usuario)) {
                    header("Location: /views/profile.php?id=" . $id_persona);
                } else {
                    header("Location: /views/admin/usuariosEditar.php?id=" . $id_persona);
                }
            }
        }

        public function delete($id) {
            try {
                $stmt1 = $this->conn->prepare("DELETE FROM personas_actos WHERE Id_persona = :id");
                $stmt1->bindParam(':id', $id);
                $stmt1->execute();

                $stmt2 = $this->conn->prepare("DELETE FROM personas WHERE Id_persona = :id");
                $stmt2->bindParam(':id', $id);
                $stmt2->execute();
                $_SESSION['estadoAccion'] = 'ok';
                header("Location: /views/usuarios.php");
            } catch(PDOException $e) {
                $_SESSION['estadoAccion'] = 'ko';
                header("Location: /views/usuarios.php");
            }
        }
    }
?>