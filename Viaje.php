<?php

class Viaje{
    private $colPasajero;
    private $responsableViaje;
	private $idViajes;
    
	public function __construct($colPasajero, $responsableViaje, $idViajes) {
		$this->colPasajero = $colPasajero;
		$this->responsableViaje = $responsableViaje;
		$this->idViajes = $idViajes;
	}

	public function getColPasajero() {
		return $this->colPasajero;
	}
	public function setColPasajero($value) {
		$this->colPasajero = $value;
	}

	public function getResponsableViaje() {
		return $this->responsableViaje;
	}
	public function setResponsableViaje($value) {
		$this->responsableViaje = $value;
	}

	public function getIdViajes() {
		return $this->idViajes;
	}
	public function setIdViajes($value) {
		$this->idViajes = $value;
	}
}