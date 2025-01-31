<?php
class ComentariosValoraciones
{
    private $conexion;

    // Constructor que recibe la conexión
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Método para obtener los comentarios y valoraciones de una habitación
    public function obtenerComentariosValoraciones($idhabitacion)
    {
        $query = "SELECT c.idcomentario, c.comentario, c.fechacomentario, c.valoracion_id, c.idusuario, u.nombreusuario AS usuario_nombre 
                  FROM comentariosyvaloraciones c 
                  JOIN usuarios u ON c.idusuario = u.idusuario 
                  WHERE c.idhabitacion = ? ORDER BY c.fechacomentario DESC";

        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $idhabitacion);  // Vincula el parámetro
        $stmt->execute();
        return $stmt->get_result();  // Devuelve el resultado
    }

    // Método para guardar un comentario en la base de datos
    public function guardarComentario($idhabitacion, $idusuario, $comentario, $valoracion)
    {
        $query = "INSERT INTO comentariosyvaloraciones (idhabitacion, idusuario, comentario, valoracion_id, fechacomentario) 
                  VALUES (?, ?, ?, ?, NOW())";

        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("iisi", $idhabitacion, $idusuario, $comentario, $valoracion);  // Vincula los parámetros
        if ($stmt->execute()) {
            return true;  // Comentario guardado exitosamente
        }
        return false;  // Error al guardar
    }
}
