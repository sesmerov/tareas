<?php
function usuarioOk($usuario, $contraseña) :bool {
  
   return (strlen($usuario)>= 8 && $usuario == strrev($contraseña));
    
}

function numeroPalabras($comentario): int{

   if(empty($comentario)) return 0;

   $comentario = trim($comentario);
   $arrayPalabras = explode(" ",$comentario);

   return count($arrayPalabras);


}

function letraMasRepetida($comentario): string{

   if(empty($comentario)) return "N/A";

   $comentario = strtolower($comentario);

   $totals = array_count_values( str_split( $comentario ));
   arsort( $totals );

   return array_keys( $totals )[0];
}

function palabraMasRepetida($comentario): string{

   $arrayPalabras = explode(" ",$comentario);

   $counts = array_count_values($arrayPalabras);
   $masRepetido = array_search(max($counts), $counts);

   return $masRepetido;
}