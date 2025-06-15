<?php

include_once 'BaseDatos.php';
include_once 'Persona.php';
include_once 'Empresa.php';
include_once 'ResponsableV.php';
include_once 'Viaje.php';
include_once 'Pasajero.php';

$salir = false;

do {
  echo "***********************************\n";
  echo "|   Bienvenido                    |\n";
  echo "| Elija una sección para acceder  |\n";
  echo "|   1. Empresa                    |\n";
  echo "|   2. Responsable                |\n";
  echo "|   3. Viaje                      |\n";
  echo "|   4. Pasajero                   |\n";
  echo "|   5. Salir                      |\n";
  echo "***********************************\n";

} while (!($opcion = readline("Ingrese una opción: ")));