<?php
require_once '../modelo/Calificacion.php';
require_once '../modelo/Conexion.php';

class ComentariosValoracionesController
{

    private $conexion;
    private $modelo;

    // Constructor que inicializa la conexión y el modelo
    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->modelo = new ComentariosValoraciones($this->conexion->getConexion());
    }

    // Método para obtener los comentarios de una habitación
    public function obtenerComentarios($idhabitacion)
    {
        return $this->modelo->obtenerComentariosValoraciones($idhabitacion);
    }

    // Método para guardar un comentario
    public function guardarComentario($idhabitacion, $idusuario, $comentario, $valoracion)
    {
        if ($this->modelo->guardarComentario($idhabitacion, $idusuario, $comentario, $valoracion)) {
            // Verificar el rol del usuario para redirigir a la carpeta correspondiente
            session_start(); // Asegúrate de que la sesión esté iniciada
            if (!isset($_SESSION['rol'])) {
                echo "Error: No se ha iniciado sesión correctamente.";
                exit();
            }

            // Determinar la carpeta según el rol del usuario
            $carpeta = '';
            if ($_SESSION['rol'] == 2) {
                $carpeta = 'Roomie';
            } elseif ($_SESSION['rol'] == 3) {
                $carpeta = 'Arrendatario';
            } else {
                echo "Rol no válido para redirigir.";
                exit();
            }

            // Redirigir a la página de los comentarios según el rol
            header("Location: ../vistas/$carpeta/ver.php?idhabitacion=" . $idhabitacion);
            exit();
        } else {
            echo "Hubo un error al guardar el comentario.";
        }
    }
}
