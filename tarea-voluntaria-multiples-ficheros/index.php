<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include("formulario.html");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $directorio = "imgusers/";
    $tamanoTotal = 0;
    $errores = [];
    $error = false;

    if ($_FILES["ficheros"]["error"][0] != 4) { // Error 4 -> No se ha adjuntado ningún fichero
        
        foreach ($_FILES["ficheros"]["name"] as $key => $value) { // Recorro todos los ficheros adjuntos aunque se encuentre error en uno. Quiero que se muestren todos los errores

            $nombre = $_FILES["ficheros"]["name"][$key]; 
            $tamanoFichero = $_FILES["ficheros"]["size"][$key];
            $tipoFichero = $_FILES['ficheros']['type'][$key];

            $tamanoTotal += $tamanoFichero;

            if ($tamanoFichero > 200000) {
                $errores[] = "El tamaño del fichero $nombre supera los 200KB";
                $error = true;
            }

            if ($tipoFichero != "image/jpeg" && $tipoFichero != "image/png") {
                $errores[] = "El tipo del fichero $nombre no es JPG o PNG";
                $error = true;
            }

            if(file_exists($directorio.$nombre)){
                $errores[] = "Ya hay un fichero con nombre $nombre en el directorio";
                $error = true;
            }

        }

        if ($tamanoTotal > 300000 && count($_FILES["ficheros"]["name"]) > 1) { //Este mensaje solo parece cuando se envia mas de un fichero
            $errores[] = "El tamaño total de los ficheros supera los 300KB";
            $error = true;
        }

        if(!$error){ //Si hay algún error en 1 solo fichero no se sube ninguna imagen

            foreach ($_FILES["ficheros"]["name"] as $key => $value){

                $temporalFichero = $_FILES['ficheros']['tmp_name'][$key];
                $nombre = $_FILES["ficheros"]["name"][$key];

                if(move_uploaded_file($temporalFichero, $directorio . $nombre)){
                    echo"<p>Fichero $nombre se ha SUBIDO CORRECTAMENTE.</p>";
                }
            }
        }

    }else{
        $errores[]= "No has adjuntado ningun fichero";
    }

    foreach ($errores as $key => $value) { //echo de todos los errores
        echo "<p>$value</p>";
    }
}
