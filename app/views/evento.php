<?php
class Evento {
    private $titulo;
    private $fecha;
    private $descripcion;

    public function __construct($titulo, $fecha, $descripcion) {
        $this->titulo = $titulo;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function toArray() {
        return [
            'titulo' => $this->titulo,
            'fecha' => $this->fecha,
            'descripcion' => $this->descripcion
        ];
    }
}