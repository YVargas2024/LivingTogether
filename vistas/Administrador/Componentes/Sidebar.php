<?php

session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 1) {
    header('Location: ../inicioRegistro.php');
    exit();
}
// Cerrar sesión
if (isset($_POST['cerrarSesion'])) {
    session_unset(); // Limpiar todas las variables de sesión
    session_destroy(); // Destruir la sesión
    header('Location: ../../index.php'); // Redirigir al inicio
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/Componentes/Sidebar.css">

    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="">
                        <span class="icon"><ion-icon name="logo-apple"></ion-icon></span>
                        <span class="title">Living-Together</span>
                    </a>
                </li>
                <li>
                    <a href="../Administrador/Administrador.php">
                        <span class="icon"><ion-icon name="stats-chart-outline"></ion-icon></span>
                        <span class="title">Estadisticas</span>
                    </a>
                </li>
                <li>
                    <a href="../Administrador/crud.php">
                        <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                        <span class="title">Gestion Usuarios</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="">
                        <span class="icon"><ion-icon name="chatbubble-ellipses-outline"></ion-icon></span>
                        <span class="title">Message</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="icon"><ion-icon name="settings-outline"></ion-icon></span>
                        <span class="title">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                        <span class="title">Perfil</span>
                    </a>
                </li> -->
                <li>
                    <form action="" method="post" style="width: 100%;">
                        <button type="submit" name="cerrarSesion" class="logout-button">
                            <span class="icon">
                                <ion-icon name="log-out-outline"></ion-icon>
                            </span>
                            <span class="title">Cerrar Sesión</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="main">
        <?php include("Header.php"); ?>

        <!-- ============SCRIPTS=========== -->
        <script src="../../constans/ComponentesJS/sidebar.js"></script>
        <!-- ===========ICONOS======= -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>