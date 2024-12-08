<?php

include_once("BiciElectrica.php");

function cargabicis()
{
    $tablaBicicletas = [];

    $manejador = fopen("Bicis.csv", "r");
    while (($data = fgetcsv($manejador)) !== FALSE) {

        if ($data[4] == 1) {
            $tablaBicicletas[] = new Bicicleta((int)$data[0], (int)$data[1], (int)$data[2], (int)$data[3], (bool)$data[4]);
        }
    }
    fclose($manejador);

    return $tablaBicicletas;
}

function mostrartablabicis($tabla)
{
    $resultado = "";
    $resultado .= "<table>
    <tr>
    <th>Id</th>
    <th>Coord X</th>
    <th>Coord Y</th>
    <th>Bateria</th>
    </tr>";

    foreach ($tabla as $key => $bici) {
        $resultado.="<tr>
        <td>$bici->id</td>
        <td>$bici->coordx</td>
        <td>$bici->coordy</td>
        <td>$bici->bateria</td>
        </tr>";
    }

    $resultado .= "</table>";
    return $resultado;
}

function bicimascercana($coordx,$coordy,$tabla)
{
    $distancia = PHP_INT_MAX;
    $biciMasCercana = null;

    foreach ($tabla as $key => $bicicleta) {
        if($bicicleta->distancia($coordx,$coordy)<$distancia){
            $distancia = $bicicleta->distancia($coordx,$coordy);
            $biciMasCercana = $bicicleta;
        }
    }

    return  $biciMasCercana;
}

// Programa principal
$tabla = cargabicis();
if (!empty($_GET['coordx']) && !empty($_GET['coordy'])) {
    $biciRecomendada = bicimascercana($_GET['coordx'], $_GET['coordy'], $tabla);
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>MOSTRAR BICIS OPERATIVAS</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>

</head>

<body>
    <h1> Listado de bicicletas operativas </h1>
    <?= mostrartablabicis($tabla); ?>
    <?php if (isset($biciRecomendada)) : ?>
        <h2> Bicicleta disponible más cercana es <?= $biciRecomendada ?> </h2>
        <button onclick="history.back()"> Volver </button>
    <?php else : ?>
        <h2> Indicar su ubicación: <h2>
                <form>
                    Coordenada X: <input type="number" name="coordx"><br>
                    Coordenada Y: <input type="number" name="coordy"><br>
                    <input type="submit" value=" Consultar ">
                </form>
            <?php endif ?>
</body>

</html>