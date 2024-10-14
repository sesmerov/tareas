<!-- Realizar un programa en PHP que genere aleatoriamente cartones de Bingo que sean correctos: 

NORMAS QUE DEBE CUMPLIR UN CARTÓN CORRECTO

Deber mostrar 15 valores entre 1 y 90
Todas las filas tienen que tener 5 valores y 4 casillas vacías
Cada columna tiene valores de su decena de forma ordenada
La primera : 1 a 9 (9 valores)
la segunda : 10 a 19 (10 valores)
La tercera : 20 a 29 ( 10 valores)
....
la última  : 80 a 90 (11 valores)
Existen tres columnas con 1 valor y resto solo tiene 2
Dos columnas consecutivas no pueden tener los valores o huecos en las misma posiciones. 
Por ejemplo:  si la primera columna tiene valores en la fila 1 y 3 la siguiente columna no puede tener valores en la fila 1 y 3 . -->

<?php

const FILAS = 3;
const COLUMNAS = 9;

function generarArray(): array
{

    $array = [[],[],[]];
    $numerosIncluidos = [];

    for ($i = 0; $i < FILAS; $i++) {
        for ($j = 0; $j < COLUMNAS; $j++) {

            if ($j == 0) {
                $array[$i][$j] = rand(1, 9);
            } else if ($j == 1) {
                $array[$i][$j] = rand(10, 19);
            } else if ($j == 2) {
                $array[$i][$j] = rand(20, 29);
            } else if ($j == 3) {
                $array[$i][$j] = rand(30, 39);
            } else if ($j == 4) {
                $array[$i][$j] = rand(40, 49);
            } else if ($j == 5) {
                $array[$i][$j] = rand(50, 59);
            } else if ($j == 6) {
                $array[$i][$j] = rand(60, 69);
            } else if ($j == 7) {
                $array[$i][$j] = rand(70, 79);
            } else{
                $array[$i][$j] = rand(80, 90);
            }

            if (in_array($array[$i][$j], $numerosIncluidos)) { //Evitar duplicidad de numeros en el array
                $j--;
            } else {
                $numerosIncluidos[] = $array[$i][$j];
            }
        }
    }
    return $array;
}

function ordenarColumnasArray($array):array
{
    for ($j = 0; $j < COLUMNAS; $j++) {
        $columna = array_column($array, $j); // Obtener la columna como un array
        sort($columna); // Ordenar la columna

        // Colocar los valores ordenados de nuevo en el array
        for ($i = 0; $i < FILAS; $i++) {
            $array[$i][$j] = $columna[$i];
        }
    }
    return $array;
}

function vaciarArray($array):array
{
    $columnas = range(0, 8);
    shuffle($columnas);
    $columnas1Elemento = array_slice($columnas, 0, 3);
    $columnas2Elementos = array_diff(range(0, 8), $columnas1Elemento);

    //////////// Vaciando columnas de 1 elemento
    for ($j = 0; $j < COLUMNAS; $j++) {
        $filaAleatoria = rand(0, 2);
        if (in_array($j, $columnas1Elemento)) {
            for ($i = 0; $i < FILAS; $i++) {
                if ($i !== $filaAleatoria) {
                    $array[$i][$j] = "";
                }
            }
        }
    }

    ///////////// Vaciando columnas de 2 elementos
    //Vaciando la 1ª columna
    $filaAVaciarInicial = rand(0, 2);
    for ($j = 0; $j < 1; $j++) {
        if (in_array($j, $columnas2Elementos)) {
            for ($i = 0; $i < FILAS; $i++) {
                if ($i == $filaAVaciarInicial) {
                    $array[$i][$j] = "";
                }
            }
        }
    }

    //Vaciando el resto de columnas
    for ($j = 1; $j < COLUMNAS; $j++) {
        for ($i = 0; $i < FILAS; $i++) {
            if (in_array($j, $columnas2Elementos)) {
                $filaAVaciar = random_int(0, 2);
                while ($array[$filaAVaciar][$j - 1] == "" && in_array($j-1, $columnas2Elementos)) {
                    $filaAVaciar = random_int(0, 2);
                }
                if ($i == $filaAVaciar) {
                    $array[$i][$j] = "";
                    break;
                }
            }
        }
    }

    return $array;
}

function representarCarton($array)
{
    foreach ($array as $fila) {
        echo "<tr>";
        foreach ($fila as $valor) {
            if ($valor == "") {
                echo "<td style='background-color: #AAAACD;'> $valor </td>";
            } else {

                echo "<td style='background-color: #E6E6FF;'><span>$valor </span> $valor </td>";
            }
        }
        echo "</tr>";
    }
}

$correctoFilas = false;
$correctoColumnas = false;

while (!$correctoFilas || !$correctoColumnas) { //Comprobar que el carton generado es correcto y si no generar otro hasta que lo sea
                                                
    $array = generarArray();
    $array = ordenarColumnasArray($array);
    $array = vaciarArray($array);

    $columnasCorrectas = 0;                 //Comprobando columnas
    for ($j = 0; $j < COLUMNAS; $j++) {
        $elementosVacios = 0;
        $columna = array_column($array, $j);
        for ($i = 0; $i < FILAS; $i++) {
            if ($columna[$i] == "") {
                $elementosVacios++;
            }
        }
        if ($elementosVacios > 0) {
            $columnasCorrectas++;
        } else {
            $columnasCorrectas = 0;
            break;
        }
    }

    if ($columnasCorrectas == COLUMNAS) {
        $correctoColumnas = true;
    }else{
        $correctoColumnas = false;
    }

    $filasCorrectas = 0;              //Comprobando filas
    for ($i = 0; $i < FILAS; $i++) {
        $elementosVacios = 0;
        for ($j = 0; $j < COLUMNAS; $j++) {
            if ($array[$i][$j] == "") {
                $elementosVacios++;
            }
        }
        if ($elementosVacios == 4) {
            $filasCorrectas++;
        }
    }
    if ($filasCorrectas == FILAS) {
        $correctoFilas = true;
    } else{
        $correctoFilas = false;
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bingo</title>
    <style>
        table {
            border: 4px solid RGB(0,0,120);
            border-collapse: collapse;
        }

        td,
        th {
            border: 2px solid RGB(120,120,180);
            padding-bottom: 10px;
            font-size: 45px;
            font-weight: 600;
            color: rgb(0,0,120);
            min-height: 50px;
            min-width: 60px;
            text-align: center;
        }
        span{
            display: block;
            text-align: left;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <table>
        <?= representarCarton($array) ?>
    </table>
</body>

</html>