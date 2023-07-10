<?php
    class TipoUsuario {
        private $Id_tipo_usuario;
        private $Descripcion;
    
        public function __construct($Id_tipo_usuario, $Descripcion) {
            $this->Id_tipo_usuario = $Id_tipo_usuario;
            $this->Descripcion = $Descripcion;
        }
    
        public function getId_tipo_usuario() {
            return $this->Id_tipo_usuario;
        }
    
        public function getDescripcion() {
            return $this->Descripcion;
        }
    
        public function setId_tipo_usuario($Id_tipo_usuario) {
            $this->Id_tipo_usuario = $Id_tipo_usuario;
        }
    
        public function setDescripcion($Descripcion) {
            $this->Descripcion = $Descripcion;
        }
    }
?>
