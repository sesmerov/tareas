<?php

session_start();

function tablaCompra()
{
    $resultado = "";

    if (empty($_SESSION["arrayCompra"])) {
        return $resultado;
    } else {
        $resultado .= "Este es su pedido: <br> <table>";

        foreach ($_SESSION["arrayCompra"] as $key => $value) {
            $resultado .= "<tr><td>$key</td><td>$value</td>";
        }

        $resultado .= "</table>";

        return $resultado;
    }
}

$compraRealizada = tablaCompra();

if (!isset($_SESSION["cliente"])) {
    include("bienvenida.php");
} else {
    include("compra.php");
}

if (!empty($_GET["cliente"])) {
    $_SESSION["cliente"] = $_GET["cliente"];
    header("Location: " . $_SERVER['PHP_SELF']);
}


if (isset($_POST["accion"]) && $_POST["accion"] == "Anotar") {

    $cantidad = (int)$_POST["cantidad"];
    if ($cantidad != 0) {
        if (!isset($_POST["fruta"], $_SESSION["arrayCompra"][$_POST["fruta"]])) {
            $_SESSION["arrayCompra"][$_POST["fruta"]] = $cantidad;
        } else {

            $_SESSION["arrayCompra"][$_POST["fruta"]] += $cantidad;

            if ($_SESSION["arrayCompra"][$_POST["fruta"]] <= 0) {
                unset($_SESSION["arrayCompra"][$_POST["fruta"]]);
            }
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
}

if (isset($_POST["accion"]) && $_POST["accion"] == "Terminar") {
    ob_clean();
    include("despedida.php");
    session_destroy();
}
