<?php
class Persona{
    private $nombre;
    private $apellido;
    private $dni;

	public function __construct($nombre, $apellido, $dni) {
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->dni = $dni;
	}

	public function getNombre() {
		return $this->nombre;
	}

	public function setNombre($value) {
		$this->nombre = $value;
	}

	public function getApellido() {
		return $this->apellido;
	}

	public function setApellido($value) {
		$this->apellido = $value;
	}

	public function getDni() {
		return $this->dni;
	}

	public function setDni($value) {
		$this->dni = $value;
	}
}