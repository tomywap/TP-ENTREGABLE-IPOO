<?php
include_once 'persona.php';
include_once 'Viaje.php';

class Pasajero extends Persona{
	//Atributos
    private $tel;
	private $idPasajero;
	private $objViaje;
	private $mensaje;

	//puse valores predeterminados para poder crear el objeto sin parametros. (esto es especialmente util en listarPasajeros()).
	public function __construct($nombre = "", $apellido = "", $dni = "", $tel = "",$idPasajero = "",$objViaje = null) {
		parent::__construct($nombre, $apellido, $dni);
		$this->tel = $tel;
		$this->idPasajero = $idPasajero;
		$this->objViaje = $objViaje;
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
	
	public function getMensaje() {
		return $this->mensaje;
	}
	public function setMensaje($value) {
		$this->mensaje = $value;
	}

	public function cargarPasajero($dni, $nombre, $apellido, $tel,  $objViaje, $idPasajero = null) {
		parent::cargarPersona($dni, $nombre, $apellido);
		$this->setTel($tel);
		$this->setObjViaje($objViaje);
		$this->setIdPasajero($idPasajero);
	}

	//modificado para que funcione la busqueda por idpasajero, antes estaba por DNI y quedaba redundante la primary key.
	public function buscarPasajero($id){
		$base = new BaseDatos();
		$consultaPasajero = "SELECT * FROM pasajero WHERE idpasajero=" . $id . "";
		$resp = false;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaPasajero)) {
				if ($row2 = $base->Registro()) {
					$this->setNombre($row2['pnombre']);
					$this->setApellido($row2['papellido']);
					$this->setDni($row2['pdocumento']);
					$this->setTel($row2["ptelefono"]);
					$this->setIdPasajero($row2['idpasajero']);
					$this->setObjViaje($row2["idviaje"]);
					$resp = true;
				}
			} else {
				$this->setMensaje($base->getERROR());
			}
		} else {
				$this->setMensaje($base->getERROR());
		}
		return $resp;
	}

	//modificado el insertar() para que inserte en la tabla pasajero
	public function insertarPasajero(){
		$base = new BaseDatos();
		$resp = false;
		$idViaje = $this->getObjViaje() != null ? $this->getObjViaje()->getIdviaje() : null;
		if(parent::insertar()){
			$consultaPasajero = "INSERT INTO pasajero(pdocumento,pnombre,papellido,ptelefono,idviaje) 
			VALUES ('".$this->getDni()."', '".$this->getNombre()."', '".$this->getApellido()."', '".$this->getTel()."', ".($idViaje !== null ? "'$idViaje'" : "null").")";
				if($base->Iniciar()){
					if($base->Ejecutar($consultaPasajero)){
						$resp = true;
					} else {
					$this->setMensaje($base->getERROR());
				}
				} else {
					$this->setMensaje($base->getERROR());
				}
			return $resp;
		}
    }

	// sirve para modificar los datos de un pasajero en la base de datos
	public function modificarPasajero(){
		$base = new BaseDatos();
		$resp = false;
		$idViaje = $this->getObjViaje() != null ? $this->getObjViaje()->getIdviaje() : null;
		if (parent::modificar()){
            $consultaUpdate = "UPDATE pasajero SET ptelefono = '" . $this->getTel() . "', idviaje = " . ($idViaje != null ? "'$idViaje'" : "null") . " WHERE idpasajero = '" . $this->getIdPasajero() . "'";
            if ($base->Iniciar()) {
				if ($base->Ejecutar($consultaUpdate)) {
					$resp = true;
				} else {
					$this->setMensaje($base->getERROR());
				}
			} else {
				$this->setMensaje($base->getERROR());
			}
		}
		return $resp;
	}

	// lista los pasajeros de la base de datos
	public  function listarPasajeros($condicion=""){
        $arregloPasajero = null;
        $base=new BaseDatos();
        $consultaPasajero="SELECT * FROM pasajero ";
        if ($condicion!=""){
            $consultaPasajero=$consultaPasajero.' WHERE '.$condicion;
        }
        $consultaPasajero .= " order by idpasajero ";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaPasajero)){
                $arregloPasajero = array();
                while($row2 = $base->Registro()){
                    $dni = $row2['pdocumento'];
                    $nombre = $row2['pnombre'];
                    $apellido = $row2['papellido'];
					$tel = $row2['ptelefono'];
					$idPasajero = $row2['idpasajero'];

					$idViaje = $row2['idviaje'];
					$objViaje = new Viaje();
					$objViaje->buscar($idViaje);

                    $pasajero = new Pasajero();
                    $pasajero->cargarPasajero($dni, $nombre, $apellido, $tel, $objViaje, $idPasajero);
                    array_push($arregloPasajero, $pasajero);
                }
            }    else {
                $this->setMensaje($base->getERROR());
            }
        }    else {
            $this->setMensaje($base->getERROR());
        }
        return $arregloPasajero;
    }

	// elimina un pasajero de la base de datos
	public function eliminarPasajero(){
		$base = new BaseDatos();
		$resp = false;
		if($base->Iniciar()){
			$consultaBorra = "DELETE FROM pasajero WHERE idpasajero=". $this->getIdPasajero();
			if($base->Ejecutar($consultaBorra)){
				$resp = true;
			}    else {
				$this->setMensaje($base->getERROR());
            }
        }    else {
			$this->setMensaje($base->getERROR());
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