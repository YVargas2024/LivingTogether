<?php

session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 3) {
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
<?php
if (isset($_SESSION['correo'])) {
?>
    <link rel="stylesheet" href="../../css/header.css">
    <header>
        <div class="nav container">
            <!-- Logo -->
            <a href="" class="logo" style="color: white;  text-decoration: none; font-size: 20px;">Living Together</a>

            <!-- NavBar -->
            <div class="navbar">
                <a href="./habitaciones.php" class="nav-link">Viviendas</a>
                <a href="./Roomies.php" class="nav-link">Roomies</a>
            </div>

            <!-- Información del Usuario -->
            <div class="user-info">
                <!-- Foto y detalles del usuario siempre visibles -->
                <!-- <img src="../../../img/user.png" alt="Foto de perfil" class="profile-pic"> -->
                <div class="user-details">
                    <span class="user-name">Bienvenido Arrendatario</span>
                    <span class="user-email"><?php echo $_SESSION['correo']; ?></span>
                </div>
                <!-- Icono para mostrar el menú desplegable -->
                <div class="dropdown-icon" onclick="toggleDropdown()">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <!-- Menú desplegable para el botón de Cerrar Sesión -->
                <div class="dropdown-content">
                    <!-- Opción de Editar Perfil -->
                    <a href="./editPerfil.php" class="edit-profile">
                        <span class="icon">
                            <ion-icon name="pencil-outline"></ion-icon>
                        </span>
                        <span class="title">Editar Perfil</span>
                    </a>
                    <a href="./arrendatario.php" class="edit-profile">
                        <span class="icon">
                            <ion-icon name="pencil-outline"></ion-icon>
                        </span>
                        <span class="title">Tus habitaciones</span>
                    </a>
                    <!-- Opción de Cerrar Sesión -->
                    <form action="" method="post">
                        <button type="submit" name="cerrarSesion" class="logout-btn">
                            <span class="icon">
                                <ion-icon name="log-out-outline"></ion-icon>
                            </span>
                            <span class="title">Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            </div>
            <br>
        </div>
    </header>
    <script>
        function toggleDropdown() {
            // Alterna la clase "active" solo en el icono del menú desplegable
            document.querySelector('.dropdown-icon').classList.toggle('active');
        }

        // Cerrar el menú si se hace clic fuera de él
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown-icon, .dropdown-icon *')) {
                document.querySelector('.dropdown-icon').classList.remove('active');
            }
        }
    </script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js" type="module"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js" nomodule></script>
<?php
} else {
    header('Location: ../../../index.php');
}
?>