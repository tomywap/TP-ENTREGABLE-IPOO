<?php
include_once 'persona.php';

class Pasajero extends Persona{
	//Atributos
    private $tel;
	private $idPasajero;
	private $objViaje;

	public function __construct($nombre, $apellido, $dni, $tel,$idPasajero,$objViaje) {
		parent::__construct($nombre, $apellido, $dni);
		$this->tel = $tel;
		$this->idPasajero=$idPasajero;
		$this->objViaje=$objViaje;
	}

	public function getTel() {
		return $this->tel;
	}
	public function setTel($value) {
		$this->tel = $value;
	}

	public function getIdPasajero() {
		return $this->idPasajero;
	}

	public function setIdPasajero($value) {
		$this->idPasajero = $value;
	}

	public function getObjViaje() {
		return $this->objViaje;
	}

	public function setObjViaje($value) {
		$this->objViaje = $value;
	}
	public function cargar($dni, $nombre, $apellido, $idPasajero, $tel, $objViaje) {
        parent::cargarPersona($dni, $nombre, $apellido);
        // Asigna los valores adicionales
        $this->setTel($tel);
        $this->setObjViaje($objViaje);
        $this->setIdPasajero($idPasajero);
    }

	public function buscarPasajero($idPasajero){
		$base = new BaseDatos();
		$consultaPersona = "SELECT * FROM pasajero WHERE idpasajero=".$idPasajero;
		$resp = false;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaPersona)) {
				if ($row2 = $base->Registro()) {
					parent::buscarPersona($this->getDni());
					$this->setIdPasajero($idPasajero);
					$this->setTel($row2["ptelefono"]);
					$this->setObjViaje($row2["idviaje"]);
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

	public function insertarPasajero(){
		$base = new BaseDatos();
		$idViaje = $this->getObjViaje()->getIdviaje();
		$resp = false;
		if(parent::insertar()){
			$consultaPersona = "INSERT INTO pasajero(pdocumento,ptelefono,idviaje) 
			VALUES (".$this->getDni().",'".$this->getTel()."','".$idViaje."')";
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
    }

	public function modificar(){
		$base = new BaseDatos();
		$resp = false;
		if (parent::modificar()) {
                $consultaUpdate = "UPDATE pasajero SET ptelefono = '" . $this->getTel() . "', idviaje = '" . $this->getObjViaje()->getIdviaje() . "' WHERE idpasajero = '" . $this->getIdPasajero() . "'";
            }
		return $resp;
	}

	public function __toString()
	{
		return "Telefono: " . $this->getTel().
		"Id pasajero: " . $this->getIdPasajero().
		"Obj: " . $this->getObjViaje()->getIdViaje();
	}
}