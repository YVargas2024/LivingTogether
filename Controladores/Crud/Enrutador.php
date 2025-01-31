<?php
class Enrutador
{
    public function cargarVista($vista)
    {
        $rutaVista = '../../vistas/Administrador/' . $vista . '.php';
        if (file_exists($rutaVista)) {
            include_once($rutaVista);
        } else {
            include_once('../../vistas/Administrador/error.php'); // Vista de error si no existe
        }
    }

    public function validarGet($variable)
    {
        if (empty($variable)) {
            include_once('../../vistas/Administrador/inicio.php');
            return false; // Indica que no es válido
        }
        return true; // Es válido
    }
}
