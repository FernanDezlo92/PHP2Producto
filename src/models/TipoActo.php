<?php
    class TipoActo {
        private $Id_tipo_acto;
        private $Descripcion;
    
        public function __construct($Id_tipo_acto, $Descripcion) {
            $this->Id_tipo_acto = $Id_tipo_acto;
            $this->Descripcion = $Descripcion;
        }
    
        public function getId_tipo_acto() {
            return $this->Id_tipo_acto;
        }
    
        public function getDescripcion() {
            return $this->Descripcion;
        }
    
        public function setId_tipo_acto($Id_tipo_acto) {
            $this->Id_tipo_acto = $Id_tipo_acto;
        }
    
        public function setDescripcion($Descripcion) {
            $this->Descripcion = $Descripcion;
        }
    }
?>
