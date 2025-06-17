<?php
include_once 'BaseDatos.php';
class Persona{
    private $nombre;
    private $apellido;
    private $dni;
	private $mensaje;

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

	public function getMensaje() {
		return $this->mensaje;
	}
	public function setMensaje($value) {
		$this->mensaje = $value;
	}

	// creamos una funcion y cargamos otra vez para la base de datos directa
	public function cargarPersona($dni, $nombre, $apellido){
		$this->setNombre($nombre);
		$this->setApellido($apellido);
		$this->setDni($dni);
	}

	// listar nos muestra todos los datos de objeto persona de la base de datos
	public function listar($condicion=""){
        $arregloPersona = null;
        $base=new BaseDatos();
        $consultaPersonas="SELECT * FROM persona ";
        if ($condicion!=""){
            $consultaPersonas=$consultaPersonas.' WHERE '.$condicion;
        }
        $consultaPersonas .= " order by pdocumento ";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaPersonas)){
                $arregloPersona = array();
                while($row2 = $base->Registro()){
                    $dni = $row2['pdocumento'];
                    $nombre = $row2['pnombre'];
                    $apellido = $row2['papellido'];
                    $persona = new Persona();
                    $persona->cargarPersona($nombre, $apellido, $dni);
                    array_push($arregloPersona, $persona);
                }
            }    else {
                $this->setMensaje($base->getERROR());
            }
        }    else {
            $this->setMensaje($base->getERROR());
        }
        return $arregloPersona;
    }
//  busca una persona por su DNI y carga los datos en el objeto actual
	public function buscarPersona($dni){
		$base = new BaseDatos();
		$consultaPersona = "SELECT * FROM persona WHERE pdocumento=".$dni;
		$resp = false;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaPersona)) {
				if ($row2 = $base->Registro()) {
					$this->setDni($row2['pdocumento']);
					$this->setNombre($row2["pnombre"]);
					$this->setApellido($row2["papellido"]);
					$resp = true;
				}
			}    else {
                $this->setMensaje($base->getERROR());
            }
        }    else {
            $this->setMensaje($base->getERROR());
        }
		return $resp;
	}
// inserta una persona en la base de datos
	public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		$consultaPersona = "INSERT INTO persona(pdocumento,papellido,pnombre) 
		VALUES ('".$this->getDni()."','".$this->getApellido()."','".$this->getNombre()."')";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				$resp = true;
			}   else {
                $this->setMensaje($base->getERROR());
            }
        }    else {
            $this->setMensaje($base->getERROR());
        }
		return $resp;
	}
// modifica los datos de una persona en la base de datos
	public function modificar(){
		$base = new BaseDatos();
		$resp = false;
		$consultaPersona = "UPDATE persona SET papellido='".$this->getApellido()."',pnombre='".$this->getNombre()."' WHERE pdocumento=". $this->getDni();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				$resp = true;
			}    else {
                $this->setMensaje($base->getERROR());
            }
        }    else {
            $this->setMensaje($base->getERROR());
        }
		return $resp;
	}

	// elimina una persona de la base de datos
	public function eliminar(){
		$base = new BaseDatos();
		$resp = false;
		if($base->Iniciar()){
			$consultaBorra = "DELETE FROM persona WHERE pdocumento=". $this->getDni();
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
// devuelve un string con los datos de la persona
	public function __toString()
	{
		return "\nNombre: " . $this->getNombre().
		"\nApellido: " . $this->getApellido(). 
		"\nDNI: " . $this->getDni();
	}
}
?>