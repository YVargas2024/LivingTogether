<?php
// Verifica si la sesión ya está activa antes de llamar a session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Solo iniciar la sesión si no hay una activa
}

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}

// Almacena el nombre del usuario y rol para su uso en el header
$datos = isset($_SESSION['datos']) ? htmlspecialchars($_SESSION['datos']) : 'Invitado';
$rol_id = isset($_SESSION['rol_id']) ? htmlspecialchars($_SESSION['rol_id']) : 0;
$correo = htmlspecialchars($_SESSION['correo']);
// $foto = htmlspecialchars($_SESSION['foto']); // Descomentar si la foto se usa

// Determinar el saludo según el rol del usuario
switch ($rol_id) {
    case 1:
        $saludo = "Arrendatario";
        break;
    case 2:
        $saludo = "Roomie";
        break;
    case 3:
        $saludo = "Administrador";
        break;
    default:
        $saludo = "Usuario";
        break;
}
