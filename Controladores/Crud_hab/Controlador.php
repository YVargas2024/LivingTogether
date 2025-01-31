<?php
include_once("../../modelo/Habitaciones.php");

class controladorHabitaciones
{
    private $habitaciones;

    public function __construct()
    {
        $this->habitaciones = new Habitacion();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['idusuario'])) {
            return [];
        }

        $this->habitaciones->set("idusuario", $_SESSION['idusuario']);
        $resultado = $this->habitaciones->Listar($_SESSION['idusuario']);
        return $resultado;
    }

    public function crear($direccion, $descripcion, $precio, $fechapublicacion, $disponibilidad_id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['idusuario'])) {
            die("Error: No hay usuario logueado.");
        }

        $fotoRuta = '';
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
            $fotoNombre = basename($_FILES['foto']['name']);
            $fotoRuta = "../../img/img_inmuebles/" . $fotoNombre;
            move_uploaded_file($_FILES['foto']['tmp_name'], $fotoRuta);
        }

        $fechapublicacion = date("Y-m-d H:i:s", strtotime($fechapublicacion));

        $this->habitaciones->set("direccion", $direccion);
        $this->habitaciones->set("descripcion", $descripcion);
        $this->habitaciones->set("precio", $precio);
        $this->habitaciones->set("fechapublicacion", $fechapublicacion);
        $this->habitaciones->set("disponibilidad_id", $disponibilidad_id);
        $this->habitaciones->set("idusuario", $_SESSION['idusuario']);
        $this->habitaciones->set("foto", $fotoRuta);

        $resultado = $this->habitaciones->crear();
        return $resultado;
    }

    public function Eliminar($idhabitacion)
    {
        $this->habitaciones->set("idhabitacion", $idhabitacion);
        $this->habitaciones->Eliminar();
    }

    public function ver($idhabitacion)
{
    $this->habitaciones->set("idhabitacion", $idhabitacion); // Set the idhabitacion for the habitacion object
    $row = $this->habitaciones->ver(); // Corrected: Use $this->habitaciones instead of $this->habitacion
    $telefono = $this->habitaciones->obtenerTelefonoPorIdUsuario($row['idusuario']); // Get the phone number
    $row['telefono'] = $telefono; // Add the phone number to the result
    return $row;
}

    public function editar($idhabitacion, $direccion, $descripcion, $precio, $fechapublicacion, $disponibilidad_id, $fotoRuta = null)
    {
        // Verificar si la foto se ha proporcionado
        if ($fotoRuta) {
            $this->habitaciones->set('foto', $fotoRuta);
        }

        // Actualizar los datos de la habitación
        $this->habitaciones->set('idhabitacion', $idhabitacion);
        $this->habitaciones->set('direccion', $direccion);
        $this->habitaciones->set('descripcion', $descripcion);
        $this->habitaciones->set('precio', $precio);
        $this->habitaciones->set('fechapublicacion', $fechapublicacion);
        $this->habitaciones->set('disponibilidad_id', $disponibilidad_id);

        // Llamar al método editarHabitacion del modelo para actualizar la habitación
        $this->habitaciones->editarHabitacion(
            $idhabitacion, 
            $direccion, 
            $descripcion, 
            $precio, 
            $fechapublicacion, 
            $disponibilidad_id, 
            $fotoRuta // Pasar la ruta de la foto si existe
        );
    }

    public function listarDisponibilidad()
    {
        // Suponiendo que hay una tabla llamada 'disponibilidad' en la base de datos
        $conexion = new Conexion();
        $consulta = "SELECT * FROM disponibilidad"; // Ajusta la consulta si es necesario
        $result = $conexion->consultaRetorno($consulta);

        // Retorna los resultados
        return $result;
    }
    public function listarTodasLasHabitaciones()
    {
        $resultado = $this->habitaciones->listarTodas();
        return $resultado;
    }

    
}
