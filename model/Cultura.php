<?php
class Cultura {
    private $idCultura; // Atributo para el identificador de la cultura
    private $nombre;
    private $descripcion;
    private $ubicacion;
    private $imagenCultura;
    private $fechaCreacion;
    private $informacion; // Nuevo atributo para la columna 'informacion'
    private $idEstado; // Atributo para el estado

    // Constructor actualizado para incluir el nuevo parámetro 'informacion' y 'idEstado'
    public function __construct($idCultura, $nombre, $descripcion, $ubicacion, $imagenCultura, $fechaCreacion, $informacion, $idEstado) {
        $this->idCultura = $idCultura; // Inicializamos el idCultura
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->ubicacion = $ubicacion;
        $this->imagenCultura = $imagenCultura;
        $this->fechaCreacion = $fechaCreacion;
        $this->informacion = $informacion; // Inicializamos el nuevo atributo
        $this->idEstado = $idEstado; // Inicializamos el estado
    }


    // Métodos para obtener los valores de los atributos
    public function getIdCultura() {
        return $this->idCultura;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getUbicacion() {
        return $this->ubicacion;
    }

    public function getImagenCultura() {
        return $this->imagenCultura;
    }

    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    public function getInformacion() {
        return $this->informacion;
    }

    public function getIdEstado() {
        return $this->idEstado;
    }
}
?>
