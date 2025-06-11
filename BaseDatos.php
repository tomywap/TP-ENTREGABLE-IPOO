<?php

class BaseDatos
{
  private $HOSTNAME;
  private $BASEDATOS;
  private $USUARIO;
  private $CLAVE;
  private $CONEXION;
  private $QUERY;
  private $RESULT;
  private $ERROR;

  public function __construct()
  {
    $this->HOSTNAME = "127.0.0.1";
    $this->BASEDATOS = "bdviajes";
    $this->USUARIO = "root";
    $this->CLAVE = "";
    $this->RESULT = null;
    $this->QUERY = "";
    $this->ERROR = "";
  }

  /**
   * Inicia la conexión con la base de datos
   * @return boolean
   */
  public function Iniciar()
  {
    $resp = false;
    $conexion = mysqli_connect($this->HOSTNAME, $this->USUARIO, $this->CLAVE, $this->BASEDATOS);

    if ($conexion) {
      if (mysqli_select_db($conexion, $this->BASEDATOS)) {
        $this->CONEXION = $conexion;
        unset($this->QUERY);
        unset($this->ERROR);
        $resp = true;
      } else {
        $this->ERROR = mysqli_errno($conexion) . ": " . mysqli_error($conexion);
      }
    } else {
      $this->ERROR = mysqli_connect_errno() . ": " . mysqli_connect_error();
    }

    return $resp;
  }

  /**
   * Ejecuta una consulta en la Base de Datos.
   * Recibe la consulta en una cadena enviada por parámetro.
   * @param string $consulta
   * @return boolean
   */
  public function Ejecutar($consulta)
  {
    $resp = false;
    unset($this->ERROR);
    $this->QUERY = $consulta;
    if ($this->RESULT = mysqli_query($this->CONEXION, $consulta)) {
      $resp = true;
    } else {
      $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
    }
    return $resp;
  }

  /**
   * Devuelve un registro retornado por la ejecución de una consulta.
   * El puntero se desplaza al siguiente registro de la consulta.
   * @return array|null
   */
  public function Registro()
  {
    $resp = null;
    if ($this->RESULT) {
      unset($this->ERROR);
      if ($temp = mysqli_fetch_assoc($this->RESULT)) {
        $resp = $temp;
      } else {
        mysqli_free_result($this->RESULT);
      }
    } else {
      $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
    }
    return $resp;
  }

  /**
   * Devuelve el ID de un campo autoincrement utilizado como clave de una tabla.
   * Retorna el ID numérico del registro insertado, devuelve null si la ejecución falla.
   * @param string $consulta
   * @return int|null
   */
  public function devuelveIDInsercion($consulta)
  {
    $resp = null;
    unset($this->ERROR);
    $this->QUERY = $consulta;
    if ($this->RESULT = mysqli_query($this->CONEXION, $consulta)) {
      $id = mysqli_insert_id($this->CONEXION);
      $resp = $id;
    } else {
      $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
    }
    return $resp;
  }

  // Getter y Setter del atributo ERROR
  public function getERROR()
  {
    return $this->ERROR;
  }

  public function setERROR($ERROR)
  {
    $this->ERROR = $ERROR;
  }
}
