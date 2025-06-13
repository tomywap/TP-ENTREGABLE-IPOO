<?php
include_once "persona.php";


$objPersona = new Persona();

$objPersona->cargarPersona('mati','gagagaga','4444444');
$objPersona->cargarPersona('tototot','gagagagaefikefief','4644444');

$objPersona->listar();
