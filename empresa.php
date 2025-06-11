<?php
class Empresa{
    private $nombreEmpresa;
    private $idEmpresa;
    private $colViajes;

	public function __construct($nombreEmpresa, $idEmpresa, $viajes = []) {
		$this->nombreEmpresa = $nombreEmpresa;
		$this->idEmpresa = $idEmpresa;
		$this->viajes = $viajes;
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

	public function getViajes() {
		return $this->viajes;
	}
	public function setViajes($value) {
		$this->viajes[] = $value;
	}

    public function buscarViaje(){
        
    }
}