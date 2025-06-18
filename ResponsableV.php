<?php
include_once 'persona.php';
class ResponsableV extends Persona{
	private $numEmpleado;
    private $numLicencia;
	private $mensaje;
	
	public function __construct($numEmpleado = "", $numLicencia = "", $nombre = "", $apellido = "", $dni = "") {
		parent::__construct($nombre, $apellido, $dni);
		$this->numEmpleado = $numEmpleado;
		$this->numLicencia = $numLicencia;
	}
	
	public function getNumEmpleado() {
		return $this->numEmpleado;
	}
	public function setNumEmpleado($value) {
		$this->numEmpleado = $value;
	}
	
	public function getNumLicencia() {
		return $this->numLicencia;
	}
	public function setNumLicencia($value) {
		$this->numLicencia = $value;
	}

	public function getMensaje() {
		return $this->mensaje;
	}
	public function setMensaje($value) {
		$this->mensaje = $value;
	}
	
	public function cargarResponsable($nombre, $apellido, $numEmpleado, $numLicencia) {
		$this->setNombre($nombre);
		$this->setApellido($apellido);
		$this->setNumEmpleado($numEmpleado);
		$this->setNumLicencia($numLicencia);
    }
	
	public function buscarResponsable($num){
		$base = new BaseDatos();
		$consultaResponsable = "SELECT * FROM responsable WHERE rnumeroempleado=" . $num . "";
		$resp = false;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaResponsable)) {
				if ($row2 = $base->Registro()) {
					$this->setNumEmpleado($row2['rnumeroempleado']);
					$this->setNumLicencia($row2["rnumerolicencia"]);
					$this->setNombre($row2['rnombre']);
					$this->setApellido($row2['rapellido']);
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

	public function insertarResponsable(){
		$base = new BaseDatos();
		$resp = false;
		$consultaResponsable = "INSERT INTO responsable(rnumeroempleado,rnumerolicencia,rnombre,rapellido) 
		VALUES ('".$this->getNumEmpleado()."','".$this->getNumLicencia()."','".$this->getNombre()."','".$this->getApellido()."')";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){
				$resp = true;
			} else {
				$this->setMensaje($base->getERROR());
			}
		} else {
			$this->setMensaje($base->getERROR());
		}
		return $resp;
	}

	public function modificarResponsable(){
		$base = new BaseDatos();
		$resp = false;
        $consultaUpdate = "UPDATE responsable SET rnombre = '" . $this->getNombre() . "', rapellido = '" . $this->getApellido() . "', rnumerolicencia = '" . $this->getNumLicencia() . "' WHERE rnumeroempleado = " . $this->getNumEmpleado();
        if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaUpdate)) {
				$resp = true;
			} else {
				$this->setMensaje($base->getERROR());
			}
		} else {
			$this->setMensaje($base->getERROR());
		}
	return $resp;
	}

	public  function listarResponsables($condicion = ""){
        $arregloResponsables = null;
        $base=new BaseDatos();
        $consultaResponsable = "SELECT * FROM responsable ";
        if ($condicion != ""){
            $consultaResponsable .= ' WHERE ' . $condicion;
        }
        $consultaResponsable .= " order by rnumeroempleado ";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaResponsable)){
                $arregloResponsables = array();
                while($row2 = $base->Registro()){
                    $numEmpleado = $row2['rnumeroempleado'];
                    $numLicencia = $row2['rnumerolicencia'];
                    $nombre = $row2['rnombre'];
					$apellido = $row2['rapellido'];
                    $responsable = new ResponsableV();
                    $responsable->cargarResponsable($nombre, $apellido, $numEmpleado, $numLicencia);
                    array_push($arregloResponsables, $responsable);
                }
            }    else {
                $this->setMensaje($base->getERROR());
            }
        }    else {
            $this->setMensaje($base->getERROR());
        }
        return $arregloResponsables;
    }

	public function eliminarResponsable(){
		$base = new BaseDatos();
		$resp = false;
		if($base->Iniciar()){
			$consultaBorra = "DELETE FROM responsable WHERE rnumeroempleado=". $this->getNumEmpleado();
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





}