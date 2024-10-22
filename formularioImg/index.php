<?php

function verArmas()
{

    $resultado = "";
    if (!isset($_POST["armas"])) {
        $resultado .= "SIN ARMAS";
    } else {
        for ($i=0; $i < count($_POST["armas"]) ; $i++) {
            if($i == count($_POST["armas"])-2){
                $resultado .= $_POST["armas"][$i] . " y ";
            }else if ($i == count($_POST["armas"])-1){
                $resultado .= $_POST["armas"][$i];
            }else{
                $resultado .= $_POST["armas"][$i] . ", ";
            }
        }
    }
    return $resultado;
}

function getImage()
{
    $src = "./manny-calavera.png"; // Imagen por defecto

    if (isset($_FILES['fichero']["name"]) && $_FILES['fichero']['error'] == 0) {
        $nombreFichero = $_FILES['fichero']['name'];
        $tipoFichero = $_FILES['fichero']['type'];
        $tamanioFichero = $_FILES['fichero']['size'];
        $temporalFichero = $_FILES['fichero']['tmp_name'];


        // Verificar que uploads existe y tenemos permisos. Verificar tamaño del archivo y tipo para subir a carpeta uploads. 
        if ( is_dir("./uploads") && is_writable("./uploads")
        && $tamanioFichero <= 10000 && $tipoFichero == "image/png") {
            if (move_uploaded_file($temporalFichero, './uploads/' . $nombreFichero)) {
                $src = "./uploads/" . $nombreFichero;
            } 
        }
    }
    return $src;
}




if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include("captura.html");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre =trim(htmlspecialchars( $_POST["nombre"])); //tratamiento inyeccion
    $alias = trim(htmlspecialchars($_POST["alias"])); //tratamiento inyeccion
    $edad = $_POST["edad"];
    $resultado = verArmas();
    $magia = (!isset($_POST["magia"]) || $_POST["magia"] != "si") ? "NO" : "SI";


    $errorSubida = false; //Mensaje superior
    $errorMensaje = false; //Mensaje inferior

    if(isset($_FILES['fichero']['name'])){

        if($_FILES['fichero']['type'] != "image/png" || $_FILES['fichero']['size'] > 10000){
            $errorSubida = true;
            if($_FILES['fichero']['error']!= 4){
                $errorMensaje = true;
            }
        }
    }

    $mensajeSubida = ($errorSubida)? "NO se ha subido imagen": "Imagen subida";
    $errorSubida = false;
    $src = getImage();
    $mensajeError = ($errorMensaje)? "Error al subir la imagen" : "";

    $mensaje = <<<MSG
    <div id="body">
    <h1>Datos del Jugador</h1>
    <div id="flex">
        <div id="datos">
            <p><strong>Nombre: </strong>$nombre </p>
            <p><strong>Alias:</strong>$alias </p>
            <p><strong>Edad:</strong> $edad</p>
            <p><strong>Armas seleccionadas:</strong> $resultado</p>
            <p><strong>¿Practica artes mágicas?</strong> $magia</p>
        </div>
        <div id="imagen">
        <p><strong>$mensajeSubida</strong></p>
        <img src="$src" alt="Imagen ">
        <p>$mensajeError</p>
        </div>
    </div>
    </div>
    MSG;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imagen Procesada</title>
    <style>
        *{
            margin: 0px;
            padding: 0px;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            
        }

        #body{
            width: 80%;
            margin: 0px auto;
            margin-top: 10px;
            background-color: yellow;
            border-radius: 15px;
        }

        h1 {
            text-align: center;
            padding: 20px;
        }

        #flex {
            display: flex;
        }

        #flex>div {
            width: 100%;
        }

        div > *{
            padding: 10px;
        }
        img{
            max-width: 100%;
        }
    </style>
</head>

<body>
    <?= (!isset($mensaje) ? "" : $mensaje) ?>
</body>

</html>