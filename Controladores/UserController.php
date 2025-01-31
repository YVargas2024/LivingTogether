<?php
include_once '../modelo/Conexion.php';
include_once '../modelo/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Manejo del registro
    if (isset($_POST['register'])) {
        $username = $_POST['username'];  // Agregado para nombre de usuario
        $correo = $_POST['correo'];
        $password = $_POST['password2']; // Cambiado a 'password2' para el registro
        $telefono = $_POST['telefono'];
        $rol = $_POST['rol'];

        // Validación para asegurarse de que los campos no estén vacíos
        if (empty($username) || empty($correo) || empty($password) || empty($telefono) || empty($rol)) {
            echo '<div class="alert">Por favor, complete todos los campos.</div>';
            exit();
        }

        $user = new User();

        // Llamada al método 'registerUser' para registrar el nuevo usuario
        if ($user->registerUser($username, $correo, $password, $telefono, $rol)) {
            session_start();
            $_SESSION['correo'] = $correo;
            $_SESSION['rol'] = $rol; // Guardamos el rol en la sesión
            header('Location: ../vistas/welcome.php');
            exit();
        } else {
            // Si el correo ya está registrado, mostramos el mensaje de error
            echo '<div class="alert">El correo electrónico ya está registrado.</div>';
        }
    }

    // Manejo del inicio de sesión
    elseif (isset($_POST['login'])) {
        $correo = $_POST['correo'];
        $password = $_POST['password'];

        if (empty($correo) || empty($password)) {
            echo '<div class="alert">Correo o contraseña vacío</div>';
            exit();
        }

        $user = new User();
        $userData = $user->getUser($correo, $password);

        if ($userData) {
            session_start();
            $_SESSION['correo'] = $correo;
            $_SESSION['rol'] = $userData['idrol']; // Guardamos el rol en la sesión
            $_SESSION['idusuario'] = $userData['idusuario']; // Guardamos el idusuario en la sesión

            // Redirigimos según el rol del usuario
            switch ($userData['idrol']) {
                case 1: // administrador
                    header('Location: ../vistas/Administrador/Administrador.php');
                    break;
                case 2: // roomie
                    header('Location: ../vistas/Roomie/habitaciones.php');
                    break;
                case 3: // arrendatario
                    header('Location: ../vistas/Arrendatario/arrendatario.php');
                    break;
                default:
                    echo '<div class="alert">Rol no válido.</div>';
                    exit();
            }
        } else {
            echo '<div class="alert">Usuario no existe o contraseña incorrecta</div>';
        }
    }
}
?>
