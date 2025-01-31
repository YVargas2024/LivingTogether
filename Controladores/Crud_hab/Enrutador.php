<?php
class Enrutador
{
    public function cargarVista($vista)
    {
        switch ($vista):
            case "crear":
                include_once('../../vistas/Arrendatario/' . $vista . '.php');
                break;
            case "ver":
                include_once('../../vistas/Arrendatario/' . $vista . '.php');
                break;
            case "editar":
                include_once('../../vistas/Arrendatario/' . $vista . '.php');
                break;
            case "eliminar":
                include_once('../../vistas/Arrendatario/' . $vista . '.php');
                break;
            case "inicio":
                include_once('../../vistas/Arrendatario/' . $vista . '.php');
                break;
            default:
                include_once('../../vistas/Arrendatario/error.php');
        endswitch;
    }
    public function validarGet($variable)
    {
        if (empty($variable)) {
            include_once('../../vistas/Arrendatario/inicio.php');
        } else {
            return true;
        }
    }
}
