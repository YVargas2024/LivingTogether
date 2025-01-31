<?php
include_once(__DIR__ . '/../modelo/Perfil.php'); // Usando __DIR__ para una ruta más confiable
include_once(__DIR__ . '/../modelo/Conexion.php'); // Incluimos la clase de conexión

class ControladorPerfil
{
    private $perfil;
    private $conexion;

    public function __construct()
    {
        // Crear una instancia de la conexión
        $this->conexion = new Conexion();
        // Pasar la conexión al modelo
        $this->perfil = new Perfil($this->conexion);
    }

    public function index($idusuario)
    {
        return $this->perfil->listar($idusuario);
    }

    public function crear($data, $foto = null)
    {
        foreach ($data as $key => $value) {
            $this->perfil->set($key, $value);
        }
        $this->perfil->crear(); // Crea el perfil

        // Obtener el último id del perfil creado
        $idperfil = $this->conexion->ultimoId();

        // Si se ha proporcionado una foto, la subimos
        if ($foto && $foto['tmp_name']) {
            $fotoData = file_get_contents($foto['tmp_name']); // Obtener contenido del archivo
            $this->perfil->subirFoto($idperfil, $fotoData, $foto['name']); // Llamar al modelo para subir la foto
        }
    }
    public function editar($idperfil, $data, $foto = null)
    {
        // Actualizar los datos del perfil
        $this->perfil->set("idperfil", $idperfil);
        foreach ($data as $key => $value) {
            $this->perfil->set($key, $value);
        }
        $this->perfil->editar();

        // Si hay una foto proporcionada, actualizarla
        if ($foto && $foto['tmp_name']) {
            $fotoData = file_get_contents($foto['tmp_name']);
            $this->perfil->subirFoto($idperfil, $fotoData, $foto['name']); // Llamar al método para actualizar o insertar la foto
        }
    }


    public function eliminar($idperfil)
    {
        $this->perfil->set("idperfil", $idperfil);
        $this->perfil->eliminar();
    }
    public function eliminarFoto($idperfil)
    {
        $this->perfil->set("idperfil", $idperfil);
        $this->perfil->eliminarFoto();
    }


    public function ver($idperfil)
    {
        $this->perfil->set("idperfil", $idperfil);
        return $this->perfil->ver();
    }
}
