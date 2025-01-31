<?php
require_once __DIR__ . '/../Modelo/EstadisticasModel.php';

class EstadisticasController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new EstadisticasModel();
    }

    public function mostrarEstadisticas()
    {
        return $this->modelo->obtenerEstadisticas();
    }
}
