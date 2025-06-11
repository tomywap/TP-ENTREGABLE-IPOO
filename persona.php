<?php
class Persona{
    private $nombre;
    private $apellido;
    private $dni;

	public function __construct() {
		$this->nombre = "";
		$this->apellido = "";
		$this->dni = "";
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

	public function cargarPersona($nombre, $apellido, $dni){
		$this->setNombre($nombre);
		$this->setApellido($apellido);
		$this->setDni($dni);
	}

	public function buscarPersona($dni){
		$base = new BaseDatos();
		$consultaPersona = "SELECT * FROM persona WHERE pdocumento=".$dni;
		$resp = false;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaPersona)) {
				if ($row2 = $base->Registro()) {
					$this->setDni($dni);
					$this->setNombre($row2["pnombre"]);
					$this->setApellido($row2["papellido"]);
					$resp = true;
				}
			} else {
				$base->getERROR();
			}
		} else {
				$base->getERROR();
		}
		return $resp;
	}


	public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		$consultaPersona = "INSERT INTO persona(nombre,apellido,dni) 
		VALUES (".$this->getDni().",'".$this->getApellido()."','".$this->getNombre()."')";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				$resp = true;
			} else {
				$base->getERROR();
			}
		} else {
				$base->getERROR();
			}
		return $resp;
	}

	public function modificar(){
		$base = new BaseDatos();
		$resp = false;
		$consultaPersona = "UPDATE persona SET papellido='".$this->getApellido()."',pnombre='".$this->getNombre()."' WHERE pdocumento=". $this->getDni();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				$resp = true;
			} else {
				$base->getERROR();
			}
		} else {
				$base->getERROR();
			}
		return $resp;
	}

	public function eliminar(){
		$base = new BaseDatos();
		$resp = false;
		if($base->Iniciar()){
			$consultaBorra = "DELETE FROM persona WHERE pdocumento=". $this->getDni();
			if($base->Ejecutar($consultaBorra)){
				$resp = true;
			} else {
				$base->getERROR();
			}
		} else {
				$base->getERROR();
			}
		return $resp;
	}

	public function __toString()
	{
		return "\nNombre: " . $this->getNombre().
		"\nApellido: " . $this->getApellido(). 
		"\nDNI: " . $this->getDni();
	}
}