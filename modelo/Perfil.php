<?php
require_once('Conexion.php');

class Perfil
{
    private $idperfil;
    private $idusuario;
    private $nombre;
    private $segundo_nombre;
    private $apellidos;
    private $segundo_apellido;
    private $edad;
    private $género_id;
    private $visibilidad;
    private $descripcion;
    private $profesion;
    private $idrol;
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }

    public function set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function get($atributo)
    {
        return $this->$atributo;
    }

    public function listar($idusuario)
    {
        $sql = "SELECT * FROM perfiles WHERE idusuario = '$idusuario'";
        $result = $this->conexion->consultaRetorno($sql);
        return $result;
    }

    public function crear()
    {
        $sql = "INSERT INTO perfiles (idusuario, nombre, segundo_nombre, apellidos, segundo_apellido, edad, género_id, visibilidad, descripcion, profesion, idrol) VALUES 
                ('{$this->idusuario}', '{$this->nombre}', '{$this->segundo_nombre}', '{$this->apellidos}', '{$this->segundo_apellido}', '{$this->edad}', '{$this->género_id}', '{$this->visibilidad}', '{$this->descripcion}', '{$this->profesion}', '{$this->idrol}')";
        $this->conexion->consultaSimple($sql);
    }

    public function editar()
    {
        $sql = "UPDATE perfiles SET nombre='{$this->nombre}', segundo_nombre='{$this->segundo_nombre}', apellidos='{$this->apellidos}', segundo_apellido='{$this->segundo_apellido}', edad='{$this->edad}', género_id='{$this->género_id}', visibilidad='{$this->visibilidad}', descripcion='{$this->descripcion}', profesion='{$this->profesion}', idrol='{$this->idrol}' WHERE idperfil='{$this->idperfil}'";
        $this->conexion->consultaSimple($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM perfiles WHERE idperfil='{$this->idperfil}'";
        $this->conexion->consultaSimple($sql);
    }
    public function eliminarFoto()
    {
        $sql = "DELETE FROM fotos_perfil WHERE idperfil='{$this->idperfil}'";
        $this->conexion->consultaSimple($sql);
    }

    public function ver()
    {
        $sql = "SELECT * FROM perfiles WHERE idperfil='{$this->idperfil}' LIMIT 1";
        $result = $this->conexion->consultaRetorno($sql);
        return mysqli_fetch_assoc($result);
    }
    public function subirFoto($idperfil, $fotoData, $fotoDescripcion)
    {
        // Escapar caracteres especiales en la descripción para evitar problemas con SQL
        $fotoDescripcion = mysqli_real_escape_string($this->conexion->getConexion(), $fotoDescripcion);

        // Verificar si el perfil ya tiene una foto
        $sql = "SELECT idfoto FROM fotos_perfil WHERE idperfil = '$idperfil'";
        $resultado = $this->conexion->consultaRetorno($sql);

        if ($resultado->num_rows > 0) {
            // Si el perfil ya tiene una foto, actualízala
            $sql = "UPDATE fotos_perfil SET fotop = ?, descripcion = '$fotoDescripcion' WHERE idperfil = '$idperfil'";
        } else {
            // Si no tiene foto, inserta una nueva
            $sql = "INSERT INTO fotos_perfil (idperfil, fotop, descripcion) VALUES ('$idperfil', ?, '$fotoDescripcion')";
        }

        // Preparar la declaración para manejar el binario
        $stmt = $this->conexion->getConexion()->prepare($sql);
        $stmt->bind_param("b", $fotoData); // 'b' para blob
        $stmt->send_long_data(0, $fotoData); // Enviar la foto como dato binario

        if (!$stmt->execute()) {
            die("Error al subir o actualizar la foto: " . $stmt->error);
        }

        $stmt->close();
    }


    public function obtenerFoto($idperfil)
    {
        $sql = "SELECT * FROM fotos_perfil WHERE idperfil = '$idperfil' LIMIT 1";
        $result = $this->conexion->consultaRetorno($sql);
        return mysqli_fetch_assoc($result); // Devuelve la foto como un array
    }
}
