<?php
// CLASE DE CONEXION INCLUIDA
include_once('Conexion.php');

//CREAMOS CLASE DE habitacion
class Habitacion
{
    private $idhabitacion;
    private $idusuario;
    private $direccion;
    private $descripcion;
    private $precio;
    private $fechapublicacion;
    private $disponibilidad_id;
    private $foto;

    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }

    public function set($atributo, $contenido)
    {
        $this->$atributo = $contenido;
    }

    public function get($atributo)
    {
        return $this->$atributo;
    }

    public function Listar($idusuario)
    {
        $sql = "SELECT 
        h.idhabitacion,
            h.idusuario,
            h.direccion,
            h.descripcion,
            h.precio,
            h.fechapublicacion,
            h.disponibilidad_id,
            d.estado,
            f.idfoto,
            f.foto
        FROM 
            habitaciones h
        LEFT JOIN 
            fotoshabitaciones f ON h.idhabitacion = f.idhabitacion
        LEFT JOIN
            disponibilidad d ON h.disponibilidad_id = d.iddisponibilidad
        WHERE 
            h.idusuario = '$idusuario'";  

        $resultado = $this->conexion->consultaRetorno($sql);
        return $resultado;
    }

    public function crear()
    {
        $sql_check_disponibilidad = "SELECT COUNT(*) as count FROM disponibilidad WHERE iddisponibilidad = '{$this->disponibilidad_id}'";
        $result = $this->conexion->consultaRetorno($sql_check_disponibilidad);
        $row = mysqli_fetch_assoc($result);

        if ($row['count'] == 0) {
            throw new Exception("Error: disponibilidad_id '{$this->disponibilidad_id}' does not exist.");
        }

        $sql_habitacion = "INSERT INTO habitaciones (idusuario, direccion, descripcion, precio, fechapublicacion, disponibilidad_id) VALUES 
        ('{$this->idusuario}', '{$this->direccion}', '{$this->descripcion}', '{$this->precio}', '{$this->fechapublicacion}', '{$this->disponibilidad_id}')";
        $this->conexion->consultaSimple($sql_habitacion);

        $idhabitacion = $this->conexion->ultimoId();

        if (!empty($this->foto)) {
            $sql_foto = "INSERT INTO fotoshabitaciones (idhabitacion, foto) VALUES ('{$idhabitacion}', '{$this->foto}')";
            $this->conexion->consultaSimple($sql_foto);
        }
    }

    public function Eliminar()
    {
        $sql = "DELETE FROM habitaciones WHERE idhabitacion='{$this->idhabitacion}'";
        $this->conexion->consultaSimple($sql);
    }

    public function ver()
    {
        $sql = "
        SELECT 
            h.idhabitacion, 
            h.idusuario, 
            h.direccion, 
            h.descripcion, 
            h.precio, 
            h.fechapublicacion, 
            h.disponibilidad_id, 
            d.estado, 
            f.foto 
        FROM 
            habitaciones h 
        LEFT JOIN 
            disponibilidad d ON h.disponibilidad_id = d.iddisponibilidad 
        LEFT JOIN 
            fotoshabitaciones f ON h.idhabitacion = f.idhabitacion 
        WHERE 
            h.idhabitacion = '{$this->idhabitacion}'";

        $resultado = $this->conexion->consultaRetorno($sql);
        return mysqli_fetch_assoc($resultado);
    }

    public function editarHabitacion($idhabitacion, $direccion, $descripcion, $precio, $fechapublicacion, $disponibilidad_id, $fotoRuta = null)
    {
        $sql = "UPDATE habitaciones SET direccion='{$direccion}', descripcion='{$descripcion}', precio='{$precio}', fechapublicacion='{$fechapublicacion}', disponibilidad_id='{$disponibilidad_id}' WHERE idhabitacion='{$idhabitacion}'";
        $this->conexion->consultaSimple($sql);

        if ($fotoRuta) {
            $sql_foto = "UPDATE fotoshabitaciones SET foto='{$fotoRuta}' WHERE idhabitacion='{$idhabitacion}'";
            $this->conexion->consultaSimple($sql_foto);
        }
    }
    public function listarTodas()
{
    $sql = "SELECT 
        h.idhabitacion,
        h.idusuario,
        h.direccion,
        h.descripcion,
        h.precio,
        h.fechapublicacion,
        h.disponibilidad_id,
        d.estado,
        f.idfoto,
        f.foto
    FROM 
        habitaciones h
    LEFT JOIN 
        fotoshabitaciones f ON h.idhabitacion = f.idhabitacion
    LEFT JOIN
        disponibilidad d ON h.disponibilidad_id = d.iddisponibilidad";

    $resultado = $this->conexion->consultaRetorno($sql);
    return $resultado;
}
public function obtenerTelefonoPorIdUsuario($idusuario)
{
    $sql = "SELECT telefono FROM usuarios WHERE idusuario = '$idusuario'";
    $resultado = $this->conexion->consultaRetorno($sql);
    $telefono = mysqli_fetch_assoc($resultado)['telefono'] ?? null;
    return $telefono;
}

}
