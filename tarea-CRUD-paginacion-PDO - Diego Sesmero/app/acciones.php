<?php
include_once "Cliente.php";
include_once 'AccesoDAO.php';


function accionTerminar(){
    AccesoDAO::closeModelo();
    session_destroy();
    header("Refresh:0 url='./index.php'");
}
 
function accionAltaCliente(){
    $cliente = new Cliente();
    $orden= "Alta";
    include_once "plantillas/formulario.php";
}

function accionDetallesCliente($id){
    $db = AccesoDAO::getModelo();
    $cliente = $db->getCliente($id);
    $orden = "Detalles";
    include_once "plantillas/formulario.php";
}


function accionModificarCliente($id){
    $db = AccesoDAO::getModelo();
    $cliente = $db->getCliente($id);
    $orden="Modificar";
    include_once "plantillas/formulario.php";
}

function accionPostAlta(){
    $cliente = new Cliente();
    $cliente->first_name   = $_POST['first_name'];
    $cliente->last_name   = $_POST['last_name'];
    $cliente->email = $_POST['email'];
    $cliente->gender = $_POST['gender'];
    $cliente->ip_address = $_POST['ip_address'];
    $cliente->telefono = $_POST['telefono'];
    $db = AccesoDAO::getModelo();
    $db->altaCliente($cliente);
    
}

function accionPostModificar(){
    $cliente = new Cliente();
    $cliente->id = $_POST['id'];
    $cliente->first_name  = $_POST['first_name'];
    $cliente->last_name  = $_POST['last_name'];
    $cliente->email = $_POST['email'];
    $cliente->gender = $_POST['gender'];
    $cliente->ip_address = $_POST['ip_address'];
    $cliente->telefono = $_POST['telefono'];
    $db = AccesoDAO::getModelo();
    $db->modCliente($cliente);
    
}

function accionBorrarCliente($id){
    $db = AccesoDAO::getModelo();
    $cliente = $db->borrarCliente($id);
    header("Refresh:0 url='./index.php'");
}
