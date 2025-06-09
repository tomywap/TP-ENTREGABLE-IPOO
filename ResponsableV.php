<?php

class ResponsableV{
    private $id;
    private $numLicencia;
    private $nombre;
    private $apellido;

	public function __construct($id, $numLicencia, $nombre, $apellido) {
		$this->id = $id;
		$this->numLicencia = $numLicencia;
		$this->nombre = $nombre;
		$this->apellido = $apellido;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($value) {
		$this->id = $value;
	}

	public function getNumLicencia() {
		return $this->numLicencia;
	}

	public function setNumLicencia($value) {
		$this->numLicencia = $value;
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
}