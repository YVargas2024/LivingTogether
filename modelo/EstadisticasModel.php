<?php
require_once 'Conexion.php';

class EstadisticasModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }

    public function obtenerEstadisticas()
    {
        $sql = "
            SELECT 
                (SELECT COUNT(*) FROM habitaciones) AS total_habitaciones,
                (SELECT COUNT(*) FROM habitaciones h 
                 JOIN disponibilidad d ON h.disponibilidad_id = d.iddisponibilidad 
                 WHERE d.estado = 'disponible') AS habitaciones_disponibles,
                (SELECT COUNT(*) FROM habitaciones h 
                 JOIN disponibilidad d ON h.disponibilidad_id = d.iddisponibilidad 
                 WHERE d.estado = 'no disponible') AS habitaciones_no_disponibles,
                (SELECT COUNT(*) FROM usuarios) AS total_usuarios,
                (SELECT COUNT(*) FROM usuarios u
                 JOIN usuario_roles ur ON u.idusuario = ur.idusuario
                 JOIN roles r ON ur.idrol = r.idrol
                 WHERE r.nombre_rol = 'administrador') AS usuarios_administrador,
                (SELECT COUNT(*) FROM usuarios u
                 JOIN usuario_roles ur ON u.idusuario = ur.idusuario
                 JOIN roles r ON ur.idrol = r.idrol
                 WHERE r.nombre_rol = 'roomie') AS usuarios_roomie,
                (SELECT COUNT(*) FROM usuarios u
                 JOIN usuario_roles ur ON u.idusuario = ur.idusuario
                 JOIN roles r ON ur.idrol = r.idrol
                 WHERE r.nombre_rol = 'arrendatario') AS usuarios_arrendatario
        ";

        $resultado = $this->conexion->query($sql);

        if (!$resultado) {
            die("Error en la consulta: " . $this->conexion->error);
        }

        return $resultado->fetch_assoc();
    }
}
