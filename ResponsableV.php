<?php
include_once 'persona.php';
class ResponsableV extends Persona{
    private $numEmpleado;
    private $numLicencia;

	public function __construct($numEmpleado, $numLicencia, $nombre, $apellido, $dni) {
		parent::__construct($nombre, $apellido, $dni);
		$this->numEmpleado = $numEmpleado;
		$this->numLicencia = $numLicencia;
	}

	public function getNumEmpleado() {
		return $this->id;
	}
	public function setNumEmpleado($value) {
		$this->id = $value;
	}

	public function getNumLicencia() {
		return $this->numLicencia;
	}
	public function setNumLicencia($value) {
		$this->numLicencia = $value;
	}

}