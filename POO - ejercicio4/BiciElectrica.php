<?php

class Bicicleta
{

    private $id; // Identificador de la bicicleta (entero)
    private $coordx; // Coordenada X (entero)
    private $coordy; // Coordenada Y (entero)
    private $bateria; // Carga de la batería en tanto por ciento (entero)
    private $operativa; // Estado de la bicleta ( true operativa- false no disponible)

    public function __construct($id,$coordx,$coordy,$bateria,$operativa) {
        $this->id = $id;
        $this->coordx = $coordx;
        $this->coordy = $coordy;
        $this->bateria = $bateria;
        $this->operativa = $operativa;
      }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __toString()
    {
        return "ID: $this->id | Bateria: $this->bateria%";
    }

    public function distancia($x, $y)
    {
        return sqrt(pow($this->coordx - $x, 2) + pow($this->coordy - $y, 2));
    }
}
