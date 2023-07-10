<?php
    class Acto {
        private $Id_acto;
        private $Fecha;
        private $Hora;
        private $Titulo;
        private $Descripcion_corta;
        private $Descripcion_larga;
        private $Num_asistentes;
        private $Id_tipo_acto;
    
        public function __construct($Id_acto, $Fecha, $Hora, $Titulo, $Descripcion_corta, $Descripcion_larga, $Num_asistentes, $Id_tipo_acto) {
            $this->Id_acto = $Id_acto;
            $this->Fecha = $Fecha;
            $this->Hora = $Hora;
            $this->Titulo = $Titulo;
            $this->Descripcion_corta = $Descripcion_corta;
            $this->Descripcion_larga = $Descripcion_larga;
            $this->Num_asistentes = $Num_asistentes;
            $this->Id_tipo_acto = $Id_tipo_acto;
        }
    
        public function getId_acto() {
            return $this->Id_acto;
        }
    
        public function getFecha() {
            return $this->Fecha;
        }
    
        public function getHora() {
            return $this->Hora;
        }
    
        public function getTitulo() {
            return $this->Titulo;
        }
    
        public function getDescripcion_corta() {
            return $this->Descripcion_corta;
        }
    
        public function getDescripcion_larga() {
            return $this->Descripcion_larga;
        }
    
        public function getNum_asistentes() {
            return $this->Num_asistentes;
        }
    
        public function getId_tipo_acto() {
            return $this->Id_tipo_acto;
        }
    
        public function setId_acto($Id_acto) {
            $this->Id_acto = $Id_acto;
        }
    
        public function setFecha($Fecha) {
            $this->Fecha = $Fecha;
        }
    
        public function setHora($Hora) {
            $this->Hora = $Hora;
        }
    
        public function setTitulo($Titulo) {
            $this->Titulo = $Titulo;
        }
    
        public function setDescripcion_corta($Descripcion_corta) {
            $this->Descripcion_corta = $Descripcion_corta;
        }
    
        public function setDescripcion_larga($Descripcion_larga) {
            $this->Descripcion_larga = $Descripcion_larga;
        }
    
        public function setNum_asistentes($Num_asistentes) {
            $this->Num_asistentes = $Num_asistentes;
        }
    
        public function setId_tipo_acto($Id_tipo_acto) {
            $this->Id_tipo_acto = $Id_tipo_acto;
        }
    }
?>
