<?php
include_once "persona.php";

$objPersona = new Persona();
$objPersona->cargarPersona('Santiago','Yatzky','42912487');
$objPersona->modificar();
$array = $objPersona->listar();
$result = "";
foreach ($array as $entrada) {
    $result .= $entrada . " ";
}
echo $result;