<?php
    class Persona {
        private $Id_persona;
        private $Nombre;
        private $Apellido1;
        private $Apellido2;
        private $User;
        private $Email;
        private $Password;
        private $Id_tipo_usuario;
        private $Anonimo;

        public function __construct($Id_persona, $Nombre, $Apellido1, $Apellido2, $User, $Email, $Password, $Id_tipo_usuario, $Anonimo) {
            $this->Id_persona = $Id_persona;
            $this->Nombre = $Nombre;
            $this->Apellido1 = $Apellido1;
            $this->Apellido2 = $Apellido2;
            $this->User = $User;
            $this->Email = $Email;
            $this->Password = $Password;
            $this->Id_tipo_usuario = $Id_tipo_usuario;
            $this->Anonimo = $Anonimo;
        }

        public function getId_persona() {
            return $this->Id_persona;
        }
    
        public function setId_persona($Id_persona) {
            $this->Id_persona = $Id_persona;
        }
    
        public function getNombre() {
            return $this->Nombre;
        }
    
        public function setNombre($Nombre) {
            $this->Nombre = $Nombre;
        }
    
        public function getApellido1() {
            return $this->Apellido1;
        }
    
        public function setApellido1($Apellido1) {
            $this->Apellido1 = $Apellido1;
        }
    
        public function getApellido2() {
            return $this->Apellido2;
        }
    
        public function setApellido2($Apellido2) {
            $this->Apellido2 = $Apellido2;
        }
    
        public function getUser() {
            return $this->User;
        }
    
        public function setUser($User) {
            $this->User = $User;
        }
    
        public function getEmail() {
            return $this->Email;
        }
    
        public function setEmail($Email) {
            $this->Email = $Email;
        }
    
        public function getPassword() {
            return $this->Password;
        }
    
        public function setPassword($Password) {
            $this->Password = $Password;
        }
    
        public function getId_tipo_usuario() {
            return $this->Id_tipo_usuario;
        }
    
        public function setId_tipo_usuario($Id_tipo_usuario) {
            $this->Id_tipo_usuario = $Id_tipo_usuario;
        }
    
        public function getAnonimo() {
            return $this->Anonimo;
        }
    
        public function setAnonimo($Anonimo) {
            $this->Anonimo = $Anonimo;
        }
    }
?>
