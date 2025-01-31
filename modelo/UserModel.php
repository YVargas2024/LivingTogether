<?php
class User extends Conexion
{
    public function __construct()
    {
        parent::__construct();
    }

    // Método para registrar un nuevo usuario
    public function registerUser($nombreusuario, $correo, $password, $telefono, $rol)
    {
        // Verificamos si el correo ya existe en la base de datos
        $sqlCheck = "SELECT COUNT(*) FROM usuarios WHERE correo = ?";
        $stmtCheck = $this->getConexion()->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $correo);
        $stmtCheck->execute();
        $stmtCheck->bind_result($count);
        $stmtCheck->fetch();
        $stmtCheck->close();

        // Si el correo ya está registrado, devolvemos false
        if ($count > 0) {
            return false; // Correo ya registrado
        }

        // Hasheamos la contraseña con password_hash para mayor seguridad
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertamos los datos del usuario en la tabla 'usuarios'
        $sql = "INSERT INTO usuarios (nombreusuario, correo, password, telefono, estado) VALUES (?, ?, ?, ?, 'activo')";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param("ssss", $nombreusuario, $correo, $hashedPassword, $telefono);

        if ($stmt->execute()) {
            // Obtenemos el ID del usuario recién insertado
            $idusuario = $stmt->insert_id;

            // Asignamos el rol al usuario en la tabla 'usuario_roles'
            $sqlRol = "INSERT INTO usuario_roles (idusuario, idrol) VALUES (?, ?)";
            $stmtRol = $this->getConexion()->prepare($sqlRol);
            $stmtRol->bind_param("ii", $idusuario, $rol);

            // Devolvemos true si se asignó correctamente el rol
            return $stmtRol->execute();
        }

        return false; // Devolvemos false si no se insertó el usuario
    }

    // Método para obtener un usuario y su rol
    public function getUser($correo, $password)
    {
        // Buscamos al usuario en la base de datos
        $sql = "SELECT u.idusuario, u.nombreusuario, u.correo, u.password, r.idrol, r.nombre_rol 
                FROM usuarios u 
                JOIN usuario_roles ur ON u.idusuario = ur.idusuario
                JOIN roles r ON ur.idrol = r.idrol
                WHERE u.correo = ?";

        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $userData = $result->fetch_assoc();

            // Verificamos la contraseña
            if (password_verify($password, $userData['password'])) {
                return $userData; // Retornamos los datos del usuario si la contraseña es correcta
            }
        }

        return false; // Retornamos false si no se encontró el usuario o si la contraseña es incorrecta
    }

    // Método para actualizar la contraseña a un formato más seguro
    public function updatePassword($correo, $newPassword)
    {
        // Hasheamos la nueva contraseña
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Actualizamos la contraseña en la base de datos
        $sql = "UPDATE usuarios SET password = ? WHERE correo = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param("ss", $hashedPassword, $correo);

        return $stmt->execute(); // Devolvemos true si la contraseña se actualizó correctamente
    }
}
?>
