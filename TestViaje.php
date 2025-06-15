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

  $opcion = trim(fgets(STDIN));

  switch ($opcion) {
    case 1:
      menuDeEmpresa();
      break;

    case 2:
      //menuDeResponsableV();
      break;

    case 3:
      //menuDeViaje();
      break;

    case 4:
      //menuDePasajero();
      break;

    case 5:
      $salir = true;
      break;

    default:
      echo "Opción no válida \n";
      break;
  }
} while (!$salir);

echo "Usted ha salido del menú de opciones.\n";

function menuDeEmpresa(){
    do {
        echo "************************************\n";
        echo "|Usted accedió a la sección Empresa|\n";
        echo "| Elija una opción                 |\n";
        echo "|   1. Agregar                     |\n";
        echo "|   2. Modificar                   |\n";
        echo "|   3. Eliminar                    |\n";
        echo "|   4. Buscar                      |\n";
        echo "|   5. Listar                      |\n";
        echo "|   6. Volver al menú              |\n";
        echo "************************************\n";

        $opcionEmpr = trim(fgets(STDIN));
        $salirMenu = false;

        switch($opcionEmpr){
            case 1:
                echo "OPCIÓN AGREGAR EMPRESA\n";
                echo "Ingrese el nombre de la empresa: \n";
                $nombreEmp = trim(fgets(STDIN));
                echo "Ingrese la dirección de la empresa: \n";
                $direcEmp = trim(fgets(STDIN));
                //Creo el objeto
                $objEmp = new Empresa();
                
                $verificarNombre = "enombre LIKE '%" . $nombreEmp . "%'";
                //Si el nombre ingresado ya existe no podrá agregarlo.
                $colecEmp = $objEmp->listarEmpresa($verificarNombre);
                if(!empty($colecEmp)){
                    echo "Este nombre ya esta en uso en otra empresa: \n";
                    foreach ($colecEmp as $emp){
                        echo $emp . "\n";//Le muestro la empresa en uso
                    }
                } else {
                    //Si el nombre no esta en uso encontes lo cargo
                    $objEmp->cargarEmpresa(0, $nombreEmp, $direcEmp);
                    if($objEmp->insertar()) {
                        echo "Su Empresa ha sido agregada.\n";
                    } else {
                        echo "Ha habido un error al cargar su Empresa.\n";
                    }
                }
                break;
            case 2:
                echo "OPCIÓN MODIFICAR EMPRESA\n";
                echo "Ingrese ID de la Empresa a modificar: \n";
                $idEmp = trim(fgets(STDIN));
                $objEmp = new Empresa();
                if ($objEmp->buscarEmpresa($idEmp)) {//Busco le empresa con el id ingresado
                    echo "Empresa encontrada: \n";
                    echo "Id de Empresa: " . $objEmp->getIdEmpresa() . "\n";
                    echo "Nombre de Empresa: " . $objEmp->getEnombre() . "\n";
                    echo "Dirección: " . $objEmp->getEdireccion() . "\n";
                    echo "Ingrese el nuevo nombre para la Empresa: \n";
                    $nombreNuevo = trim(fgets(STDIN));
                    echo "Ingrese la nueva dirección para la Empresa: \n";
                    $direcNueva = trim(fgets(STDIN));

                    if(!empty($nombreNuevo)) {
                        $objEmp->setEnombre($nombreNuevo);
                    }
                    if(!empty($direcNueva)) {
                        $objEmp->setEdireccion($direcNueva);
                    }
                    if ($objEmp->modificar()) {
                        echo "Su Empresa ha sido modificada.\n";
                    } else {
                        echo "Ha habido un error al modificar su Empresa.\n";
                    }
                } else {
                    echo "Su Empresa no existe.\n";
                }
                break;
            case 3:
                echo "OPCIÓN ELIMINAR EMPRESA\n";
                echo "Ingrese ID de la Empresa a eliminar: \n";
                $idEmp = trim(fgets(STDIN));

                if (!is_numeric($idEmp)) {
                    echo "El ID de la Empresa debe ser numérico.\n";
                    break;
                }

                $objEmp = new Empresa();
                if ($objEmp->buscarEmpresa($idEmp)) {
                    if ($objEmp->eliminar()) {
                        echo "Su Empresa ha sido eliminada.\n";
                    } else {
                        echo "Ha habido un error al eliminar su Empresa.\n";
                    }
                } else {
                    echo "No se encontró la Empresa con ese ID.\n";
                }
                break;
            case 4:
                echo "OPCIÓN BUSCAR EMPRESA\n";
                echo "Ingrese ID de la Empresa a buscar: \n";
                $idEmp = trim(fgets(STDIN));

                if (!is_numeric($idEmp)) {
                    echo "El ID de la Empresa debe ser numérico.\n";
                    break;
                }

                $objEmp = new Empresa();
                if ($objEmp->buscarEmpresa($idEmp)) {
                    echo "Su Empresa ha sido encontrada: \n";
                    echo "Id de Empresa: " . $objEmp->getIdEmpresa() . "\n";
                    echo "Nombre de Empresa: " . $objEmp->getEnombre() . "\n";
                    echo "Dirección: " . $objEmp->getEdireccion() . "\n";
                } else {
                    echo "El ID es incorrecto o la Empresa no existe.\n";
                }
                break;
            case 5:
                echo "OPCIÓN LISTAR EMPRESA\n";
                $empresaObj = new Empresa();
                $empresas = $empresaObj->listarEmpresa();

                if (!empty($empresas)) {
                    foreach ($empresas as $empresa) {
                        echo "Id de Empresa: " . $empresa->getIdEmpresa() . "\n";
                        echo "Nombre de Empresa: " . $empresa->getNombre() . "\n";
                        echo "Dirección: " . $empresa->getDireccion() . "\n";
                        echo "\n";
                    }
                } else {
                    echo "No hay empresas disponibles.\n";
                }
                break;
            case 6:
                $salirMenu = true;
                break;
            default:
            echo "Esta Opción no existe. \n";
            break;
        }
    } while (!$salirMenu);
}