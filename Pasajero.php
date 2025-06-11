<?php
include_once 'persona.php';

class Pasajero extends Persona{
	//Atributos
    private $tel;

	public function __construct($nombre, $apellido, $dni, $tel) {
		parent::__construct($nombre, $apellido, $dni);
		$this->tel = $tel;
	}

	public function getTel() {
		return $this->tel;
	}
	public function setTel($value) {
		$this->tel = $value;
	}

}