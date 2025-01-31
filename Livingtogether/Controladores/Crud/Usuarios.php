<?php
include_once("../../modelo/Usuarios.php");

class controladorUsuarios
{
    // Atributo de la clase
    private $usuarios;

    // Constructor
    public function __construct()
    {
        $this->usuarios = new Usuarios();
    }

    // Listar todos los usuarios con sus roles
    public function index()
    {
        $resultado = $this->usuarios->Listar();
        return $resultado;
    }

    // Crear un usuario (con hash de contraseña y asignación de rol)
    public function crear($nombreusuario, $correo, $password, $idrol)
    {
        // Validar que el rol existe
        if (!$this->usuarios->validarRol($idrol)) {
            echo "Error: El rol proporcionado no existe.";
            return false; // Retorna false si el rol no es válido
        }

        // Hasheamos la contraseña antes de guardarla en la BD
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Asignamos los datos a la instancia de usuario
        $this->usuarios->set("nombreusuario", $nombreusuario);
        $this->usuarios->set("correo", $correo);
        $this->usuarios->set("password", $passwordHash);
        $this->usuarios->set("idrol", $idrol);

        // Ejecutamos la creación del usuario
        $resultado = $this->usuarios->crear();

        // Devolvemos true si la operación fue exitosa
        return $resultado ? true : false;
    }

    // Eliminar un usuario (y su rol asociado)
    public function Eliminar($idusuario)
    {
        $this->usuarios->set("idusuario", $idusuario);
        $this->usuarios->Eliminar();
    }

    // Ver un usuario con su rol
    public function ver($idusuario)
    {
        $this->usuarios->set("idusuario", $idusuario);
        $datos = $this->usuarios->ver();
        return $datos;
    }

    // Editar un usuario y su rol
    public function Editar($idusuario, $nombreusuario, $correo, $password = null, $idrol)
    {
        // Validar que el rol existe
        if (!$this->usuarios->validarRol($idrol)) {
            echo "Error: El rol proporcionado no existe.";
            return false; // Retorna false si el rol no es válido
        }

        $this->usuarios->set('idusuario', $idusuario);
        $this->usuarios->set('nombreusuario', $nombreusuario);
        $this->usuarios->set('correo', $correo);

        // Solo actualizamos la contraseña si se proporciona una nueva
        if (!empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $this->usuarios->set('password', $passwordHash); // Cambia 'contraseña' por 'password'
        }

        $this->usuarios->set('idrol', $idrol);
        $this->usuarios->Editar();
    }
}
