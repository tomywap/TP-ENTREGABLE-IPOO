<?php

class Pasajero{
    private $nombre;
    private $apellido;
    private $documento;
    private $telefono;


	public function __construct($nombre, $apellido, $documento, $telefono) {
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->documento = $documento;
		$this->telefono = $telefono;
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

	public function getDocumento() {
		return $this->documento;
	}

	public function setDocumento($value) {
		$this->documento = $value;
	}

	public function getTelefono() {
		return $this->telefono;
	}

	public function setTelefono($value) {
		$this->telefono = $value;
	}

}