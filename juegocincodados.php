<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego Cinco Dados</title>
    <style>
        .player{
            display: inline-block;
            font-size: 20px;
            font-weight: 700;
            height: 70px;

        }

        .array{
            font-size: 50px;
            font-weight:400;
            padding-top: 10px;
            padding-bottom: 10spx;
        }
        .array1{
            background-color: red;
        }
        .array2{
            background-color: blue;
        }

    </style>
</head>

<body>

    <?php

    $entryValuesArray = [
        1 => "&#9856;",
        2 => "&#9857;",
        3 => "&#9858;",
        4 => "&#9859;",
        5 => "&#9860;",
        6 => "&#9861;"
    ];

    $winnerMessageArray = ["Empate", "Ha ganado el jugador 1", "Ha ganado el jugador 2"];

    $player1Array = [];
    $player2Array = [];
    $player1Score = 0;
    $player2Score = 0;



    function generatePlayerArray($entryValuesArray, & $playerScore): array
    {
        $playerArray = [];
        $maxScore = PHP_INT_MIN;
        $minScore = PHP_INT_MAX;
        for ($i = 0; $i < count($entryValuesArray); $i++) {
            $randomKey = array_rand($entryValuesArray);
            
            $playerScore+= $randomKey;
            if($randomKey > $maxScore){
                $maxScore = $randomKey;
            }
            if($randomKey < $minScore){
                $minScore = $randomKey;
            }


            $playerArray[] = $entryValuesArray[$randomKey];
        }

        $playerScore -= $minScore;
        $playerScore -= $maxScore;
        return $playerArray;
    }


    function drawPlayerArray($playerArray):string{
        $draw = "";

        foreach ($playerArray as $value) {
            $draw.=$value;
        }


        return $draw;
    }

    function winnerMessage($winnerMessageArray,$player1Score,$player2Score):int{
        $value = 0;
        if($player1Score == $player2Score){
            $value = 0;
        } elseif($player1Score > $player2Score){
            $value = 1;
        } else {$value = 2;}
        return $value;
    }


    $player1Array = generatePlayerArray($entryValuesArray, $player1Score);
    $player2Array = generatePlayerArray($entryValuesArray, $player2Score);
    
    ?>

    <h1>Cinco Dados</h1>
    <p>Actualiza la pagina para mostrar una nueva tirada</p>
    <div class="player">
    Jugador 1
        <span class="array1 array"><?= drawPlayerArray($player1Array) ?></span>
         <?= $player1Score ?> puntos
    </div>
    <br>
    <div class="player">
        Jugador 2
        <span class="array2 array"><?= drawPlayerArray($player2Array) ?></span>
         <?= $player2Score ?> puntos
    </div>
    <p>Resultado: <?= $winnerMessageArray[winnerMessage($winnerMessageArray,$player1Score,$player2Score)] ?></p>


</body>

</html>