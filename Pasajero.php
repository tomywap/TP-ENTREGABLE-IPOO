<?php
include_once 'persona.php';

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

	public function cargarPasajero($dni, $nombre, $apellido, $tel, $idPasajero, $objViaje) {
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

	//los ternarios estan porque en unos testeos me tiraba error si el objViaje era null (y eso pasa seguido).
	public function insertarPasajero(){
		$base = new BaseDatos();
		$resp = false;
		$idViaje = $this->getObjViaje() != null ? $this->getObjViaje()->getIdviaje() : null;
		if(parent::insertar()){
			$consultaPasajero = "INSERT INTO pasajero(pdocumento,ptelefono,idviaje) 
			VALUES ('".$this->getDni()."','".$this->getTel()."',".($idViaje !== null ? "'$idViaje'" : "null").")";
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

	//modificado el modificar() (xd)
	//basicamente no hacia nada antes.
	//los ternarios por los null etc etc.
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

	//creado el metodo listarPasajeros().
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
					$objViaje = null;
                    $pasajero = new Pasajero();
                    $pasajero->cargarPasajero($dni, $nombre, $apellido, $tel, $idPasajero, $objViaje);
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

	//no testeado, pero deberia estar bien
	public function eliminar(){
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