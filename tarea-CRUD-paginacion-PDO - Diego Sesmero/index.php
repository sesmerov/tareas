<?php
define('FPAG', 10); // Número de clientes por página

require_once  "app/AccesoDAO.php";
require_once  "app/acciones.php";
session_start();

// Valor por defecto de la posición inicial
if (!isset($_SESSION['posini'])) {
    $_SESSION['posini'] = 0;
}

$dbh = AccesoDAO::getModelo();
$numclientes = $dbh->totalClientes();

if ($numclientes % FPAG == 0) {
    $ultimo = $numclientes - FPAG;
} else {
    $ultimo = $numclientes - ($numclientes % FPAG);
}


$primero = $_SESSION['posini'];

// Segun la paginación se cambia la posición inicial
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['orden'])) {
        switch ($_GET['orden']) {
            case "Detalles":
                accionDetallesCliente($_GET['id']);
                die();
                break;
            case "Borrar":
                accionBorrarCliente($_GET['id']);
                die();
                break;
            case "Modificar":
                accionModificarCliente($_GET['id']);
                die();
                break;
            case "Alta":
                accionAltaCliente();
                die();
                break;
            case "Primero":
                $primero = 0;
                break;
            case "Siguiente":
                $primero += FPAG;
                if ($primero > $ultimo) {
                    $primero = $ultimo;
                }
                break;
            case "Anterior":
                $primero -= FPAG;
                if ($primero < 0) {
                    $primero = 0;
                }
                break;
            case "Ultimo":
                $primero = $ultimo;
        }
        $_SESSION['posini'] = $primero;
    }
} else {
    //AÑADIR LAS ACCIONES POST
    if (isset($_POST['orden'])) {
        // limpiarArrayEntrada($_POST); //Evito la posible inyección de código
        switch ($_POST['orden']) {
            case "Añadir":
                accionPostAlta();
                break;
                case "Modificar": accionPostModificar(); break;
                //      case "Detalles":; // No hago nada
        }
    }
}


$tclientes = $dbh->getClientes($primero, FPAG);

// Acceder a la base de datos y pedir los clientes de la página
// Guardar en la variable en una tabla
// Mostrar la tabla en la vista

include "app/plantillas/principal.php";