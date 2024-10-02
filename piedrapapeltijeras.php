<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piedra, Papel, Tijera</title>
    <style>
        div {
            display: inline-block;
        }

        div p {
            text-align: center;
            font-size: 50px;
        }
        h2{
            text-align: center;
        }
    </style>
</head>

<body>

    <?php

    define('PIEDRA1',  "&#x1F91C;");
    define('PIEDRA2',  "&#x1F91B;");
    define('TIJERAS',  "&#x1F596;");
    define('PAPEL',    "&#x1F91A;");
    $player1Value;
    $player2Value;
    $textResult="";


    function generateValue(): string
    {
        $randomNumber = random_int(1, 3);
        switch ($randomNumber) {
            case 1:
                $playerValue = PIEDRA1;
                break;
            case 2:
                $playerValue = PAPEL;
                break;
            case 3:
                $playerValue = TIJERAS;
                break;
        }

        return $playerValue;
    }


    function generateWinnerText($player1Value, $player2Value): string
    {
        $text = "";

        if($player1Value == $player2Value){
            $text = "EMPATE";
        } elseif($player1Value == PIEDRA1 && $player2Value == TIJERAS || $player1Value == PAPEL && $player2Value == PIEDRA1 || $player1Value == TIJERAS && $player2Value == PAPEL){
            $text = "El Jugador 1 gana";
        } else{
            $text = "El jugador 2 gana";
        }

        return $text;
    }

    $player1Value = generateValue();
    $player2Value = generateValue();

    $textResult = generateWinnerText($player1Value,$player2Value);

    $player2Value = ($player2Value == PIEDRA1)? PIEDRA2: $player2Value;

    ?>

    <h1>¡Piedra, papel, tijera!</h1>
    <p>Actualice la página para mostrar otra partida</p>

    <div>
    <div>
        <h2>Jugador 1</h2>
        <p><?= $player1Value ?></p>
    </div>
    <div>
        <h2>Jugador 2</h2>
        <p><?= $player2Value ?></p>
    </div>
    <h2><?= $textResult ?></h2>
    </div>

</body>

</html>