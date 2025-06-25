<?php

include_once 'BaseDatos.php';
include_once 'Empresa.php';
include_once 'ResponsableV.php';
include_once 'Pasajero.php';

class Viaje {
    private $idViaje;
    private $vDestino;
    private $vCantMaxPasajeros;
    private $objEmpresa;
    private $objResponsable;
    private $vImporte;
    private $colPasajeros;
    private $msjOperacion;

    public function __construct() {
        $this->idViaje = 0;
        $this->vDestino = '';
        $this->vCantMaxPasajeros = 0;
        $this->objEmpresa = new Empresa();
        $this->objResponsable = new ResponsableV();
        $this->vImporte = 0;
        $this->colPasajeros = [];
        $this->msjOperacion = '';
    }

    public function getIdViaje() { 
        return $this->idViaje; 
    }
    public function setIdViaje($id) { 
        $this->idViaje = $id; 
    }

    public function getVDestino() { 
        return $this->vDestino; 
    }
    public function setVDestino($destino) { 
        $this->vDestino = $destino; 
    }

    public function getVCantMaxPasajeros() { 
        return $this->vCantMaxPasajeros; 
    }
    public function setVCantMaxPasajeros($cantMax) { 
        $this->vCantMaxPasajeros = $cantMax; 
    }

    public function getObjEmpresa() { 
        return $this->objEmpresa; 
    }
    public function setObjEmpresa($objEmp) { 
        $this->objEmpresa = $objEmp; 
    }

    public function getObjResponsable() { 
        return $this->objResponsable; 
    }
    public function setObjResponsable($objResp) { 
        $this->objResponsable = $objResp; 
    }

    public function getVImporte() { 
        return $this->vImporte; 
    }
    public function setVImporte($importe) { 
        $this->vImporte = $importe; 
    }

    public function getColPasajeros() { 
        return $this->colPasajeros; 
    }
    public function setColPasajeros($col) { 
        $this->colPasajeros = $col; 
    }

    public function getMsjOperacion() { 
        return $this->msjOperacion; 
    }
    public function setMsjOperacion($msj) { 
        $this->msjOperacion = $msj; 
    }

    public function cargar($id, $destino, $cantMax, $objEmp, $objResp, $importe) {
        $this->setIdViaje($id);
        $this->setVDestino($destino);
        $this->setVCantMaxPasajeros($cantMax);
        $this->setObjEmpresa($objEmp);
        $this->setObjResponsable($objResp);
        $this->setVImporte($importe);
    }

    public function pasajeDisponible() {
        $this->actualizarPasajeros();
        $hayLugar = false;
        $cantActual = count($this->getColPasajeros());
        if ($cantActual < $this->getVCantMaxPasajeros()) {
            $hayLugar = true;
        }
        return $hayLugar;
    }

    public function actualizarPasajeros() {
        $objBase = new BaseDatos();
        $consulta = "SELECT p.pdocumento, per.pnombre, per.papellido, p.ptelefono, p.idpasajero " .
                    "FROM pasajero p INNER JOIN persona per ON p.pdocumento = per.pdocumento " .
                    "WHERE p.idviaje = " . $this->getIdViaje();
        $coleccion = [];
        if ($objBase->Iniciar()) {
            if ($objBase->Ejecutar($consulta)) {
                while ($row = $objBase->Registro()) {
                    $objPasajero = new Pasajero();
                    $objPasajero->cargarPasajero($row['pdocumento'], $row['pnombre'], $row['papellido'], $row['ptelefono'], $row['idpasajero'], $this);
                    array_push($coleccion, $objPasajero);
                }
            }
        }
        $this->setColPasajeros($coleccion);
    }

    public function buscar($id) {
        $objBase = new BaseDatos();
        $consulta = "SELECT * FROM viaje WHERE idviaje = " . $id;
        $encontrado = false;
        if ($objBase->Iniciar()) {
            if ($objBase->Ejecutar($consulta)) {
                if ($row = $objBase->Registro()) {
                    $this->setIdViaje($id);
                    $this->setVDestino($row['vdestino']);
                    $this->setVCantMaxPasajeros($row['vcantmaxpasajeros']);
                    $this->setVImporte($row['vimporte']);

                    $objEmp = new Empresa();
                    if ($objEmp->buscarEmpresa($row['idempresa'])) {
                        $this->setObjEmpresa($objEmp);
                    } else {
                        $this->setMsjOperacion("Empresa no encontrada.");
                    }

                    $objResp = new ResponsableV();
                    if ($objResp->buscarResponsable($row['rnumeroempleado'])) {
                        $this->setObjResponsable($objResp);
                    } else {
                        $this->setMsjOperacion("Responsable no encontrado.");
                    }

                    $this->actualizarPasajeros();
                    $encontrado = true;
                } else {
                    $this->setMsjOperacion("No se encontró el viaje.");
                }
            } else {
                $this->setMsjOperacion($objBase->getERROR());
            }
        } else {
            $this->setMsjOperacion($objBase->getERROR());
        }
        return $encontrado;
    }

    public function listar($condicion = "") {
        $coleccion = null;
        $objBase = new BaseDatos();
        $consulta = "SELECT * FROM viaje";
        if ($condicion != "") {
            $consulta .= " WHERE " . $condicion;
        }
        $consulta .= " ORDER BY vdestino";

        if ($objBase->Iniciar()) {
            if ($objBase->Ejecutar($consulta)) {
                $coleccion = [];
                while ($row = $objBase->Registro()) {
                    $objViaje = new Viaje();
                    $objEmpresa = new Empresa();
                    $objEmpresa->buscarEmpresa($row['idempresa']);

                    $objResponsable = new ResponsableV();
                    $objResponsable->buscarResponsable($row['rnumeroempleado']);

                    $objViaje->cargar($row['idviaje'], $row['vdestino'], $row['vcantmaxpasajeros'], $objEmpresa, $objResponsable, $row['vimporte']);
                    array_push($coleccion, $objViaje);
                }
            } else {
                $this->setMsjOperacion($objBase->getERROR());
            }
        } else {
            $this->setMsjOperacion($objBase->getERROR());
        }

        return $coleccion;
    }

    public function insertar() {
        $objBase = new BaseDatos();
        $exito = false;
        if ($objBase->Iniciar()) {
            $sql = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte) VALUES (" ."'" . $this->getVDestino() . "', " .$this->getVCantMaxPasajeros() . ", " .$this->getObjEmpresa()->getIdEmpresa() . ", " .$this->getObjResponsable()->getNumEmpleado() . ", " .$this->getVImporte() . ")";
            if ($objBase->Ejecutar($sql)) {
                $exito = true;
            } else {
                $this->setMsjOperacion($objBase->getERROR());
            }
        } else {
            $this->setMsjOperacion($objBase->getERROR());
        }
        return $exito;
    }

    public function modificar() {
        $objBase = new BaseDatos();
        $modificado = false;
        if ($objBase->Iniciar()) {
            $sql = "UPDATE viaje SET " ."vdestino = '" . $this->getVDestino() . "', " ."vcantmaxpasajeros = " . $this->getVCantMaxPasajeros() . ", " ."idempresa = " . $this->getObjEmpresa()->getIdEmpresa() . ", " ."rnumeroempleado = " . $this->getObjResponsable()->getNumEmpleado() . ", " ."vimporte = " . $this->getVImporte() ." WHERE idviaje = " . $this->getIdViaje();
            if ($objBase->Ejecutar($sql)) {
                $modificado = true;
            } else {
                $this->setMsjOperacion($objBase->getERROR());
            }
        } else {
            $this->setMsjOperacion($objBase->getERROR());
        }
        return $modificado;
    }

    public function eliminar() {
        $objBase = new BaseDatos();
        $eliminado = false;

        $consultaSetNullPasajeros = "UPDATE pasajero SET idviaje = NULL WHERE idviaje = " . $this->getIdViaje();

        $consultaEliminarViaje = "DELETE FROM viaje WHERE idviaje = " . $this->getIdViaje();
        if ($objBase->Iniciar()) {
            if ($objBase->Ejecutar($consultaSetNullPasajeros)) {
                if ($objBase->Ejecutar($consultaEliminarViaje)) {
                    $eliminado = true;
                } else {
                    $this->setMsjOperacion($objBase->getERROR());
                }
            } else {
                $this->setMsjOperacion($objBase->getERROR());
            }
        } else {
            $this->setMsjOperacion($objBase->getERROR());
        }
        return $eliminado;
    }




}
