<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Acto.php';
    
    class ActoCo {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function getAll() {
            $stmt = $this->conn->prepare("SELECT ac.Id_acto, ac.Fecha, TIME_FORMAT(ac.Hora, '%H:%i') Hora, ac.Titulo, ac.Descripcion_corta, ac.Descripcion_larga, ac.Num_asistentes, ac.Id_tipo_acto, 
                                                 (SELECT COUNT(*) FROM personas_actos pa WHERE pa.Id_acto = ac.Id_acto AND pa.Ponente = 0) Num_inscritos,
                                                 ta.Descripcion Tipo_acto 
                                            FROM actos ac 
                                            JOIN tipo_acto ta ON ta.Id_tipo_acto = ac.Id_tipo_acto
                                        ORDER BY ac.Fecha DESC, ac.Hora DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getFiltered($tDate, $fDate, $id_persona) {
            $stmt = $this->conn->prepare("SELECT ac.Id_acto, ac.Fecha, TIME_FORMAT(ac.Hora, '%H:%i') Hora, ac.Titulo, ac.Descripcion_corta, ac.Descripcion_larga, 
                                                 ac.Num_asistentes, ac.Id_tipo_acto, (SELECT COUNT(*) FROM personas_actos pa WHERE pa.Id_acto = ac.Id_acto AND pa.Ponente = 0 ) Num_inscritos, 
                                                 (SELECT pa.Ponente FROM personas_actos pa WHERE pa.Id_persona = :id_persona AND pa.Id_acto = ac.Id_acto) Rol,
                                                 ta.Descripcion Tipo_acto 
                                            FROM actos ac 
                                            JOIN tipo_acto ta ON ta.Id_tipo_acto = ac.Id_tipo_acto
                                           WHERE (
                                                  (:tDate = '1' AND ac.Fecha = :fDate) OR
                                                  (:tDate = '2' AND YEARWEEK(ac.Fecha, '%x-%v') = YEARWEEK(STR_TO_DATE(CONCAT(REPLACE(:fDate, 'W', ''), '-1'), '%x-%v-%w'), '%x-%v')) OR
                                                  (:tDate = '3' AND DATE_FORMAT(ac.Fecha, '%Y-%m') = :fDate)
                                                 )
                                        ORDER BY ac.Fecha DESC , ac.Hora DESC");
            $stmt->bindParam(':tDate', $tDate);
            $stmt->bindParam(':fDate', $fDate);
            $stmt->bindParam(':id_persona', $id_persona);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getNonFiltered($id_persona) {
            $stmt = $this->conn->prepare("SELECT ac.Id_acto, ac.Fecha, TIME_FORMAT(ac.Hora, '%H:%i') Hora, ac.Titulo, ac.Descripcion_corta, ac.Descripcion_larga, 
                                                 ac.Num_asistentes, ac.Id_tipo_acto, (SELECT COUNT(*) FROM personas_actos pa WHERE pa.Id_acto = ac.Id_acto AND pa.Ponente = 0 ) Num_inscritos, 
                                                 (SELECT pa.Ponente FROM personas_actos pa WHERE pa.Id_persona = :id_persona AND pa.Id_acto = ac.Id_acto) Rol,
                                                 ta.Descripcion Tipo_acto 
                                            FROM actos ac 
                                            JOIN tipo_acto ta ON ta.Id_tipo_acto = ac.Id_tipo_acto
                                        ORDER BY ac.Fecha DESC, ac.Hora DESC");
            $stmt->bindParam(':id_persona', $id_persona);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getById($id_acto) {
            try {
                $stmt = $this->conn->prepare("SELECT Id_acto, Fecha, TIME_FORMAT(Hora, '%H:%i') Hora, Titulo, Descripcion_corta, Descripcion_larga, Num_asistentes, Id_tipo_acto FROM actos WHERE Id_acto = :id_acto");
                $stmt->bindParam(':id_acto', $id_acto);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    return new Acto($row['Id_acto'], $row['Fecha'], $row['Hora'], $row['Titulo'], $row['Descripcion_corta'], $row['Descripcion_larga'], $row['Num_asistentes'], $row['Id_tipo_acto']);
                } else {
                    return null;
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        public function getByIdRow($id_acto) {
            try {
                $stmt = $this->conn->prepare("SELECT ac.Id_acto, ac.Fecha, TIME_FORMAT(ac.Hora, '%H:%i') Hora, ac.Titulo, 
                                                     ac.Descripcion_corta, ac.Descripcion_larga, ac.Num_asistentes, ac.Id_tipo_acto, 
                                                     (SELECT ta.Descripcion FROM tipo_acto ta WHERE ta.Id_tipo_acto = ac.Id_tipo_acto) Tipo_acto
                                                FROM actos ac WHERE ac.Id_acto = :id_acto");
                $stmt->bindParam(':id_acto', $id_acto);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        public function getInscritosEnActo($Id_acto) {
            $stmt = $this->conn->prepare("SELECT pe.Id_persona, CONCAT(CONCAT_WS(' ', pe.Apellido1, pe.Apellido2), CONCAT(', ', pe.Nombre)) AS Nombre_completo, pe.Anonimo
                                            FROM personas pe JOIN personas_actos pa ON pe.Id_persona = pa.Id_persona
                                           WHERE pa.Id_acto = :id_acto AND pa.Ponente = 0 
                                        ORDER BY 2");
            $stmt->bindParam(':id_acto', $Id_acto);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getInscritosAnonimizado($Id_acto) {
            $stmt = $this->conn->prepare("SELECT pe.Id_persona, CASE WHEN pe.Anonimo = 0 THEN CONCAT(CONCAT_WS(' ', pe.Apellido1, pe.Apellido2), CONCAT(', ', pe.Nombre)) ELSE 'Usuario anónimo' END AS Nombre_completo, pe.Anonimo
                                            FROM personas pe JOIN personas_actos pa ON pe.Id_persona = pa.Id_persona
                                           WHERE pa.Id_acto = :id_acto AND pa.Ponente = 0 
                                        ORDER BY 2");
            $stmt->bindParam(':id_acto', $Id_acto);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function insert($fecha, $hora, $titulo, $descripcion_c, $descripcion_l, $asistentes, $Id_tipo_acto) {
            try {
                $stmt = $this->conn->prepare("INSERT INTO actos (Fecha, Hora, Titulo, Descripcion_corta, Descripcion_larga, Num_asistentes, Id_tipo_acto) 
                VALUES (:fecha, :hora, :titulo, :descripcion_c, :descripcion_l, :asistentes, :Id_tipo_acto)");

                $stmt->bindParam(':fecha', $fecha);
                $hora_completa = $hora . ':00';
                $stmt->bindParam(':hora', $hora_completa);
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':descripcion_c', $descripcion_c);
                $stmt->bindParam(':descripcion_l', $descripcion_l);
                $stmt->bindParam(':asistentes', $asistentes);
                $stmt->bindParam(':Id_tipo_acto', $Id_tipo_acto);

                $stmt->execute();
                $id_insertado = $this->conn->lastInsertId();
                $_SESSION['estadoAccion'] = 'ok';
                header("Location: /views/admin/actosEditar.php?id=" . $id_insertado);
            } catch(PDOException $e) {
                $_SESSION['estadoAccion'] = 'ko';
                header("Location: /views/admin/actosEditar.php?id=" . $id_acto);
            }
        }

        public function update($id_acto, $fecha, $hora, $titulo, $descripcion_c, $descripcion_l, $asistentes, $Id_tipo_acto) {
            try {
                $stmt = $this->conn->prepare("UPDATE actos SET Fecha = :fecha, Hora = :hora, Titulo = :titulo, Descripcion_corta = :descripcion_c, Descripcion_larga = :descripcion_l, Num_asistentes = :asistentes, Id_tipo_acto = :Id_tipo_acto WHERE Id_acto = :id_acto");

                $stmt->bindParam(':id_acto', $id_acto);
                $stmt->bindParam(':fecha', $fecha);
                $hora_completa = $hora . ':00';
                $stmt->bindParam(':hora', $hora_completa);
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':descripcion_c', $descripcion_c);
                $stmt->bindParam(':descripcion_l', $descripcion_l);
                $stmt->bindParam(':asistentes', $asistentes);
                $stmt->bindParam(':Id_tipo_acto', $Id_tipo_acto);

                $stmt->execute();
                $_SESSION['estadoAccion'] = 'ok';
                header("Location: /views/admin/actosEditar.php?id=" . $id_acto);
            } catch(PDOException $e) {
                $_SESSION['estadoAccion'] = 'ko';
                header("Location: /views/admin/actosEditar.php?id=" . $id_acto);
            }
        }

        public function delete($id) {
            try {
                $stmt = $this->conn->prepare("DELETE FROM actos WHERE Id_acto = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $_SESSION['estadoAccion'] = 'ok';
                header("Location: /views/actos.php");
            } catch(PDOException $e) {
                $_SESSION['estadoAccion'] = 'ko';
                header("Location: /views/actos.php");
            }
        }
    }
?>
