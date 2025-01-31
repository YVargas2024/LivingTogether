<?php
include_once('Conexion.php');

class Usuarios
{
    private $idusuario;
    private $nombreusuario;
    private $correo;
    private $password;
    private $idrol;
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

    // Método para validar si el rol existe en la tabla 'roles'
    public function validarRol($idrol)
    {
        $sql = "SELECT COUNT(*) as total FROM roles WHERE idrol = '{$idrol}'";
        $resultado = $this->conexion->consultaRetorno($sql);
        $row = mysqli_fetch_assoc($resultado);
        return $row['total'] > 0;
    }

    // Listar todos los usuarios con sus roles
    public function Listar()
    {
        $sql = "SELECT u.idusuario, u.nombreusuario, u.correo, r.nombre_rol 
                FROM usuarios u
                JOIN usuario_roles ur ON u.idusuario = ur.idusuario
                JOIN roles r ON ur.idrol = r.idrol";
        $resultado = $this->conexion->consultaRetorno($sql);
        return $resultado;
    }

    // Crear usuario y asignar rol
    public function crear()
    {
        $sqlUsuario = "INSERT INTO usuarios (nombreusuario, correo, password, fecharegistro, estado) 
                       VALUES ('{$this->nombreusuario}', '{$this->correo}', '{$this->password}', NOW(), 'activo')";
        $this->conexion->consultaSimple($sqlUsuario);
        $idUsuario = $this->conexion->ultimoId();

        // Verifica si el rol existe antes de intentar crear la relación
        if ($this->validarRol($this->idrol)) {
            $sqlRol = "INSERT INTO usuario_roles (idusuario, idrol) VALUES ('{$idUsuario}', '{$this->idrol}')";
            $this->conexion->consultaSimple($sqlRol);
        } else {
            echo "Error: El rol proporcionado no existe.";
            return false; // Indicar que hubo un error
        }

        return true; // Indicar que el usuario se creó correctamente
    }

    // Eliminar usuario y su rol
    public function Eliminar()
    {
        $sqlRol = "DELETE FROM usuario_roles WHERE idusuario = '{$this->idusuario}'";
        $this->conexion->consultaSimple($sqlRol);

        $sqlUsuario = "DELETE FROM usuarios WHERE idusuario = '{$this->idusuario}'";
        $this->conexion->consultaSimple($sqlUsuario);
    }

    // Ver usuario con su rol
    public function ver()
    {
        $sql = "SELECT u.*, r.idrol 
                FROM usuarios u
                JOIN usuario_roles ur ON u.idusuario = ur.idusuario
                JOIN roles r ON ur.idrol = r.idrol
                WHERE u.idusuario = '{$this->idusuario}' LIMIT 1";
        $resultado = $this->conexion->consultaRetorno($sql);
        $row = mysqli_fetch_assoc($resultado);

        $this->idusuario = $row['idusuario'];
        $this->nombreusuario = $row['nombreusuario'];
        $this->correo = $row['correo'];
        $this->password = $row['password'];
        $this->idrol = $row['idrol'];

        return $row;
    }

    // Editar usuario y su rol
    public function Editar()
    {
        $sqlUsuario = "UPDATE usuarios 
                       SET nombreusuario = '{$this->nombreusuario}', 
                           correo = '{$this->correo}', 
                           password = '{$this->password}' 
                       WHERE idusuario = '{$this->idusuario}'";
        $this->conexion->consultaSimple($sqlUsuario);

        $sqlRol = "UPDATE usuario_roles 
                   SET idrol = '{$this->idrol}' 
                   WHERE idusuario = '{$this->idusuario}'";
        $this->conexion->consultaSimple($sqlRol);
    }
}
