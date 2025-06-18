<?php
class Empresa{
	private $idEmpresa;
	private $eNombre;
	private $eDireccion;
	private $mensaje;

	public function __construct() {
		$this->idEmpresa = null;
		$this->eNombre = "";
		$this->eDireccion = "";
	}

	public function getIdempresa() {
		return $this->idEmpresa;
	}
	public function setIdempresa($value) {
		$this->idEmpresa = $value;
	}

	public function getEnombre() {
		return $this->eNombre;
	}
	public function setEnombre($value) {
		$this->eNombre = $value;
	}

	public function getEdireccion() {
		return $this->eDireccion;
	}
	public function setEdireccion($value) {
		$this->eDireccion = $value;
	}

	public function getMensaje() {
		return $this->mensaje;
	}
	public function setMensaje($value) {
		$this->mensaje = $value;
	}

	public function cargarEmpresa($nombreEmpresa, $direccion, $idEmpresa = null){
		$this->setEnombre($nombreEmpresa); 
        $this->setEdireccion($direccion);
		if ($idEmpresa !== null) {
			$this->setIdEmpresa($idEmpresa);
		}
    }

	public function buscarEmpresa($id){
		$base = new BaseDatos();
		$consultaEmpresa = "SELECT * FROM empresa WHERE idempresa=" . $id . "";
		$resp = false;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaEmpresa)) {
				if ($row2 = $base->Registro()) {
					$this->setIdempresa($row2['idempresa']);
					$this->setEnombre($row2['enombre']);
					$this->setEdireccion($row2['edireccion']);
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

	public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        $consultaInsert = "INSERT INTO empresa(enombre,edireccion) VALUES ('".$this->getEnombre()."','".$this->getEdireccion()."')";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaInsert)){
                $resp = true;
            } else {
                $this->setMensaje($base->getERROR());
            }
        } else {
            $this->setMensaje($base->getERROR());
        }
        return $resp;
    }

	public function modificar(){
		$base = new BaseDatos();
		$resp = false;
		$consultaEmpresa = "UPDATE empresa SET enombre='".$this->getEnombre()."',edireccion='".$this->getEdireccion()."' WHERE idempresa=". $this->getIdempresa();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){
				$resp = true;
			}    else {
                $this->setMensaje($base->getERROR());
            }
        }    else {
            $this->setMensaje($base->getERROR());
        }
		return $resp;
	}

	public function listarEmpresa($condicion=""){
        $arregloEmpresa = null;
        $base=new BaseDatos();
        $consultaEmpresa="SELECT * FROM empresa ";
        if ($condicion!=""){
            $consultaEmpresa=$consultaEmpresa.' WHERE '.$condicion;
        }
        $consultaEmpresa .= " order by idempresa ";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaEmpresa)){
                $arregloEmpresa = array();
                while($row2 = $base->Registro()){
                    $idEmpresa = $row2['idempresa'];
                    $nombreEmpresa = $row2['enombre'];
                    $direccion = $row2['edireccion'];
                    $empresa = new Empresa();
                    $empresa->cargarEmpresa($nombreEmpresa, $direccion, $idEmpresa);
                    array_push($arregloEmpresa, $empresa);
                }
            }    else {
                $this->setMensaje($base->getERROR());
            }
        }    else {
            $this->setMensaje($base->getERROR());
        }
        return $arregloEmpresa;
    }

public function eliminar() {
    $base = new BaseDatos();
    $resp = false;

    // Buscar los viajes relacionados con esta empresa
    $consultaViajes = "SELECT idviaje FROM viaje WHERE idempresa = " . $this->getIdempresa();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($consultaViajes)) {
            while ($row = $base->Registro()) {
                $objViaje = new Viaje();
                if ($objViaje->buscar($row['idviaje'])) {
                    $objViaje->eliminar(); // Elimina el viaje (también pasajero/responsable)
                }
            }

            // Una vez eliminados los viajes, elimino la empresa
            $consultaBorra = "DELETE FROM empresa WHERE idempresa = " . $this->getIdempresa();
            if ($base->Ejecutar($consultaBorra)) {
                $resp = true;
            } else {
                $this->setMensaje($base->getERROR());
            }

        } else {
            $this->setMensaje($base->getERROR());
        }
    } else {
        $this->setMensaje($base->getERROR());
    }

    return $resp;
}





}