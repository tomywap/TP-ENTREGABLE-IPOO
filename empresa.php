<?php
class Empresa{
    private $nombreEmpresa;
    private $idEmpresa;
    private $direccion;

	public function __construct($nombreEmpresa, $idEmpresa, $direccion) {
		$this->nombreEmpresa = $nombreEmpresa;
		$this->idEmpresa = $idEmpresa;
		$this->direccion = $direccion;
	}

	public function getNombreEmpresa() {
		return $this->nombreEmpresa;
	}
	public function setNombreEmpresa($value) {
		$this->nombreEmpresa = $value;
	}

	public function getIdEmpresa() {
		return $this->idEmpresa;
	}
	public function setIdEmpresa($value) {
		$this->idEmpresa = $value;
	}

	public function getDireccion() {
		return $this->direccion;
	}
	public function setDireccion($value) {
		$this->direccion = $value;
	}
}