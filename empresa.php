<?php
class Empresa{
	private $idempresa;
	private $enombre;
	private $edireccion;
	

	public function __construct($idempresa, $enombre, $edireccion) {

		$this->idempresa = $idempresa;
		$this->enombre = $enombre;
		$this->edireccion = $edireccion;
	}

	public function getIdempresa() {
		return $this->idempresa;
	}

	public function setIdempresa($value) {
		$this->idempresa = $value;
	}

	public function getEnombre() {
		return $this->enombre;
	}

	public function setEnombre($value) {
		$this->enombre = $value;
	}

	public function getEdireccion() {
		return $this->edireccion;
	}

	public function setEdireccion($value) {
		$this->edireccion = $value;
	}

		public function cargarEmpresa($nombreEmpresa,$idEmpresa, $direccion){
        $this->setNombreEmpresa ($nombreEmpresa); 
		$this->setIdEmpresa($idEmpresa);        
        $this->setDireccion($direccion);
    }

	public function buscarEmpresa(){
		$base = new BaseDatos();
		$consultaEmpresa = "SELECT * FROM empresa WHERE idempresa='" . $this->getIdempresa() . "'";
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
        $consultaInsert = "INSERT INTO empresa(enombre,edireccion) VALUES ('".$this->getNombre()."','".$this->getDireccion()."')";

        	if($base->Iniciar()){
            	if($base->Ejecutar($consultaInsert)){
                	$resp = true;
            	} else {
                	$this->setMsjOperacion($base->getERROR());
            	}
        	} else {
            	$this->setMsjOperacion($base->getERROR());
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


		public  function listarEmpresa($condicion=""){
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
					$objEmpresa = null;
                    $empresa = new Empresa();
                    $empresa->cargarEmpresa($nombreEmpresa,$idEmpresa, $direccion);
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

		public function eliminar(){
		$base = new BaseDatos();
		$resp = false;
		if($base->Iniciar()){
			$consultaBorra = "DELETE FROM empresa WHERE idempresa=". $this->getIdempresa();
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