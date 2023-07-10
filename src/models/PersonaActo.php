<?php
    class PersonaActo {
        private $Id_persona;
        private $Id_acto;
        private $Ponente;
    
        public function __construct($Id_persona, $Id_acto, $Ponente) {
            $this->Id_persona = $Id_persona;
            $this->Id_acto = $Id_acto;
            $this->Ponente = $Ponente;
        }
    
        public function getId_persona() {
            return $this->Id_persona;
        }
    
        public function getId_acto() {
            return $this->Id_acto;
        }
    
        public function getPonente() {
            return $this->Ponente;
        }
    
        public function setId_persona($Id_persona) {
            $this->Id_persona = $Id_persona;
        }
    
        public function setId_acto($Id_acto) {
            $this->Id_acto = $Id_acto;
        }
    
        public function setPonente($Ponente) {
            $this->Ponente = $Ponente;
        }
    }
?>
