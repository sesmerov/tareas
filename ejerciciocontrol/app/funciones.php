<?php
require_once('dat/datos.php');
/**
 *  Devuelve true si el código del usuario y contraseña se 
 *  encuentra en la tabla de usuarios
 *  @param $login : Código de usuario
 *  @param $clave : Clave del usuario
 *  @return true o false
 */
function userOk($login, $clave): bool
{
    global $usuarios;

    if(isset($usuarios[$login]) && $usuarios[$login][1] == $clave) return true;

    return false;
}

/**
 *  Devuelve el rol asociado al usuario
 *  @param $login: código de usuario
 *  @return ROL_ALUMNO o ROL_PROFESOR
 */
function getUserRol($login)
{
    global $usuarios;

    return $usuarios[$login][2];
}

/**
 *  Muestra las notas del alumno indicado.
 *  @param $codigo: Código del usuario
 *  @return $devuelve una cadena con una tabla html con los resultados 
 */
function verNotasAlumno($codigo): String
{
    $msg = "";
    global $nombreModulos;
    global $notas;
    global $usuarios;

    $msg .= " Bienvenido/a alumno/a: " . $usuarios[$codigo][0];
    $msg .= "<table>";
    $msg .= "<tr><th>Modulos</th><th>Notas</th> </tr>";

    for ($i=0; $i < count($nombreModulos); $i++) { 
        $msg.= "<tr><td>". $nombreModulos[$i] . "</td><td>";

        foreach ($usuarios as $key => $value) {
            if($key == $codigo){
                $msg.= $notas[$key][$i]. "</td></tr>";
                break;
            }
        }
        
    }

    $msg .= "</table>";
    return $msg;
}

/**
 *  Muestra las notas de todos alumnos. 
 *  @param $codigo: Código del profesor
 *  @return $devuelve una cadena con una tabla html con los resultados 
 */
function verNotaTodas($codigo): String
{
    $msg = "";
    global $nombreModulos;
    global $notas;
    global $usuarios;
    $msg .= " Bienvenido Profesor: " . $usuarios[$codigo][0];
    $msg .= "<table>";

    $msg .= "<tr> <th>Nombre</th>";

    foreach ($nombreModulos as $key => $value) {
        $msg.= "<th>$value</th>";
    }
    foreach ($usuarios as $key => $value) {
        if($value[2]!= ROL_PROFESOR){
            $msg.="<tr><td> $value[0]</td>";

            for ($i=0; $i < count($notas[$key]) ; $i++) { 
                $msg.= "<td>". $notas[$key][$i]."</td>";
            }

            $msg.= "</tr>";

        }
    }
    $msg .= "</tr>";
    $msg .= "</table>";
    return $msg;
}
