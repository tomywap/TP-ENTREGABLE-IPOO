<?php

class Viaje{
    private $colPasajero;
    private $responsableViaje;
    
	public function __construct($colPasajero, $responsableViaje) {
        
		$this->colPasajero = $colPasajero;
		$this->responsableViaje = $responsableViaje;
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
}